<?php
namespace Parser;

use Helpers\TemplateHelper;

class TemplateParser
{
	protected $templateFolder = '../Templates';

	/**
	 * Returns a template with its placeholders substituted with supplied data
	 *
	 * @param  string  $templateName     Template to use
	 * @param  array   $placeholderData  Data containing placeholder replacement data
	 *
	 * @return string  String of HTML
	 */
	public function parseTemplate(String $templateName, Array $placeholderData)
	{
		// Make sure our template exists
		if (!$this->checkIfTemplateExists($templateName))
		{
			// If not, we can't display the page at all. Throw an exception.
			throw new \Exception("Attempted to parse a non-existent template");
		}

		$templateFile = TemplateHelper::getTemplatePath($templateName);

		// Get the raw content of the template
		$templateContent = file_get_contents($templateFile);

		$this->replaceTemplateContentPlaceholders($templateContent, $placeholderData);
		
		return $templateContent;
	}

	/**
	 * Check if a specific template exists
	 *
	 * @param  string  $templateName  Template to check for
	 *
	 * @return boolean  True if the template exists
	 */
	protected function checkIfTemplateExists(String $templateName)
	{
		$templateList = TemplateHelper::getTemplates();

		// If template name is not in the list, the template doesn't exist
		if (!in_array($templateName, $templateList))
		{
			return false;
		}

		return true;
	}

	/**
	 * Replaces placeholder values in a string
	 *
	 * @param  string  $templateContent  String to replace placeholders in 
	 * @param  array   $placeholderData  Data containing placeholder replacement data
	 *
	 * @return void
	 */
	protected function replaceTemplateContentPlaceholders(String &$templateContent, Array $placeholderData)
	{
		$patterns     = [];
		$replacements = [];

		// Go through and assign an assortment of regex patterns and their replacement values
		foreach ($placeholderData AS $placeholder => $value)
		{
			$patterns[]     = '/{' . $placeholder . '}/';
			$replacements[] = $value;
		}

		// Search for and replace placeholders with regex
		$templateContent = preg_replace($patterns, $replacements, $templateContent);
	}
}