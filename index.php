<?php
/* Entry point for our template parser
 * Just here to add some general accessibility to our template parser's functionality.
 */

use Parser\TemplateParser;
use Helpers\TemplateHelper;

// Register Autoloads so we don't have to bother with includes for our namespaces
spl_autoload_register(function($className) {
	include_once __DIR__ . '/' . $className . '.php';
});

// Are we trying to access a template?
$template = $_GET['template'] ?? null;

// If no template is selected, we'll want to write a list of links to select one
if ($template === null)
{
	// Get all the templates
	$templateFiles = TemplateHelper::getTemplates();

	// Go through each template file and create a link for that template
	foreach ($templateFiles AS $templateName)
	{
		/*
			Write our link.
			Technically we'd probably want a full HTML page structure, but let's ignore that for simplicity.
		*/
		echo '<a href="index.php?template=' . $templateName . '">' . $templateName . '<a>';
		echo '<br>';
	}
}
else
{
	// The page data we want to show in our template. Normally this obviously wouldn't be hard coded.
	$pageData = array(
		'page_title'  => 'Template Parser Test',
		'page_header' => 'Header for template',
		'page_text'   => 'This is some test data for a template'
	);

	$parser = new TemplateParser;

	// Parse and display our template
	echo $parser->parseTemplate($template, $pageData);
}