<?php
namespace Helpers;

class TemplateHelper
{
	/**
	 * Path to the template folder relative to this file
	 *
	 * @var string
	 */
	protected static $templateFolderPath = __DIR__ . '/../Templates/';

	/**
	 * List of all the templates
	 *
	 * @var array
	 */
	protected static $templates;

	/**
	 * List of all the template paths.
	 *
	 * @var array
	 */
	protected static $templatePaths;

	/**
	 * Get a list of all the templates
	 *
	 * @return array  Array containing all the templates
	 */
	public static function getTemplates()
	{
		// We want to avoid having to rediscover the wheel every time we access this method
		if (self::$templates === null)
		{
			$templateList  = [];
			$templatePaths = [];

			// Get all the templates that exists in the templatefolder
			$templateFiles = glob(self::$templateFolderPath . '*.html');

			// Go through each template file and add them to our list
			foreach ($templateFiles AS $templatePath)
			{
				// We want to get the template name based on file name
				$templateName = pathinfo($templatePath)['filename'];

				// Populate arrays that we'll later assign to properties
				$templateList[]               = $templateName;
				$templatePaths[$templateName] = $templatePath;
			}

			self::$templates     = $templateList;
			self::$templatePaths = $templatePaths;

			return self::$templates;
		}
		else
		{
			// We have the list of templates
			return self::$templates;
		}
	}

	/**
	 * Returns the path for a specific template
	 *
	 * @param  string  $templateName  Template we want to get the path of
	 *
	 * @return string  Relative path to the template
	 */
	public static function getTemplatePath(String $templateName)
	{
		// If template paths property isn't populated, we'll have to run getTemplate to do so.
		if (self::$templatePaths === null)
		{
			self::getTemplates();
		}

		return self::$templatePaths[$templateName];
	}
}