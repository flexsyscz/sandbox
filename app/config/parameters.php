<?php
return [
	'parameters' => [
		'languages' => [
			'default' => \App\Model\Languages\LanguageCode::CS,
			'dictionaries' => \App\Model\Languages\LanguageCode::getDictionaries('%appDir%/config/languages'),
		],
	],
];