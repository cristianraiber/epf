## Filters usage

`add_filter('epfw_changelog', 'my_func_name', 10);`

```
function my_func_name( (array) $args ) {
	$args['text'] = 'changelog_text',
	$args['target'] = '$changelog_target',
	$args['version'] = 'plugin_changelog_version',
	$args['href'] = 'plugin_changelog_href'
}}```