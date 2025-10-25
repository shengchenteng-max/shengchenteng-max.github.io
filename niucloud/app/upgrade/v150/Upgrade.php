<?php

namespace app\upgrade\v150;

class Upgrade
{

    public function handle()
    {
        $addon_dir = root_path() . 'addon';
        if (is_dir($addon_dir)) {
            $addons = array_diff(scandir($addon_dir), [ '.', '..' ]);
            foreach ($addons as $addon) {
                $this->handleAddonUniappPages($addon);
            }
        }
    }

    private function handleAddonUniappPages($addon)
    {
        $addon_uniapp_pages = str_replace('/', DIRECTORY_SEPARATOR, project_path() . "niucloud/addon/{$addon}/package/uni-app-pages.php");
        if (file_exists($addon_uniapp_pages)) {
            $content = file_get_contents($addon_uniapp_pages);

            // 正则表达式用于捕获每个页面配置项
            $pagePattern = '/\{(?:[^{}]|(?R))*\}/';

            // 提取所有页面配置
            preg_match_all($pagePattern, $content, $matches);

            $addon_pages = [];

            foreach ($matches[ 0 ] as $match) {
                $addon_pages[] = "				" . str_replace("$addon/pages/", "pages/", $match);
            }

            $content = '<?php' . PHP_EOL;
            $content .= 'return [' . PHP_EOL . "    'pages' => <<<EOT" . PHP_EOL . '        // PAGE_BEGIN' . PHP_EOL;
            $content .= '        {' . PHP_EOL . '            "root": "addon/' . $addon . '", ' . PHP_EOL . '            "pages": [' . PHP_EOL;
            $content .= implode("," . PHP_EOL, $addon_pages);
            $content .= PHP_EOL . '			]' . PHP_EOL . '        },' . PHP_EOL . '// PAGE_END' . PHP_EOL . 'EOT' . PHP_EOL . '];';

            file_put_contents($addon_uniapp_pages, $content);
        }
    }

}
