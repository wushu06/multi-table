<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Commenting;

use SlevomatCodingStandard\Helpers\DocCommentHelper;
use SlevomatCodingStandard\Helpers\SniffSettingsHelper;

class ForbiddenCommentsSniff implements \PHP_CodeSniffer\Sniffs\Sniff
{

	public const CODE_COMMENT_FORBIDDEN = 'CommentForbidden';

	/** @var string[] */
	public $forbiddenCommentPatterns = [];

	/**
	 * @return mixed[]
	 */
	public function register(): array
	{
		return [
			T_DOC_COMMENT_OPEN_TAG,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile
	 * @param int $docCommentOpenPointer
	 */
	public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $docCommentOpenPointer): void
	{
		$tokens = $phpcsFile->getTokens();

		$comments = DocCommentHelper::getDocCommentDescription($phpcsFile, $docCommentOpenPointer);

		if ($comments === null) {
			return;
		}

		foreach (SniffSettingsHelper::normalizeArray($this->forbiddenCommentPatterns) as $forbiddenCommentPattern) {
			if (!SniffSettingsHelper::isValidRegularExpression($forbiddenCommentPattern)) {
				throw new \Exception(sprintf('%s is not valid PCRE pattern.', $forbiddenCommentPattern));
			}

			foreach ($comments as $comment) {
				if (preg_match($forbiddenCommentPattern, $comment->getContent()) === 0) {
					continue;
				}

				$fix = $phpcsFile->addFixableError(
					sprintf('Documentation comment contains forbidden comment "%s".', $comment->getContent()),
					$comment->getPointer(),
					self::CODE_COMMENT_FORBIDDEN
				);

				if (!$fix) {
					continue;
				}

				$phpcsFile->fixer->beginChangeset();

				$fixedDocComment = preg_replace($forbiddenCommentPattern, '', $comment->getContent());

				$phpcsFile->fixer->replaceToken($comment->getPointer(), $fixedDocComment);

				for ($i = $comment->getPointer() - 1; $i > $docCommentOpenPointer; $i--) {
					$contentWithoutSpaces = preg_replace('~ +$~', '', $tokens[$i]['content'], -1, $replacedCount);

					if ($replacedCount === 0) {
						break;
					}

					$phpcsFile->fixer->replaceToken($i, $contentWithoutSpaces);
				}

				$docCommentContent = '';
				for ($i = $docCommentOpenPointer + 1; $i < $tokens[$docCommentOpenPointer]['comment_closer']; $i++) {
					/** @var string|mixed[] $token */
					$token = $phpcsFile->fixer->getTokenContent($i);
					$docCommentContent .= is_array($token) ? $token['content'] : $token;
				}

				if (preg_match('~^[\\s\*]*$~', $docCommentContent)) {
					$pointerBeforeDocComment = $docCommentOpenPointer - 1;
					$contentBeforeWithoutSpaces = preg_replace('~[\t ]+$~', '', $tokens[$pointerBeforeDocComment]['content'], -1, $replacedCount);
					if ($replacedCount !== 0) {
						$phpcsFile->fixer->replaceToken($pointerBeforeDocComment, $contentBeforeWithoutSpaces);
					}

					for ($i = $docCommentOpenPointer; $i <= $tokens[$docCommentOpenPointer]['comment_closer']; $i++) {
						$phpcsFile->fixer->replaceToken($i, '');
					}

					$pointerAfterDocComment = $tokens[$docCommentOpenPointer]['comment_closer'] + 1;
					if (array_key_exists($pointerAfterDocComment, $tokens)) {
						$contentAfterWithoutSpaces = preg_replace('~^[\r\n]+~', '', $tokens[$pointerAfterDocComment]['content'], -1, $replacedCount);
						if ($replacedCount !== 0) {
							$phpcsFile->fixer->replaceToken($pointerAfterDocComment, $contentAfterWithoutSpaces);
						}
					}
				}

				$phpcsFile->fixer->endChangeset();
			}
		}
	}

}