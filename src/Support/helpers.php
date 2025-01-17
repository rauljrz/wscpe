<?php
if (!function_exists('dd')) {

    /**
     * Dump the passed variables and end the script.
     *
     * @return void
     */
    function dd(...$vars)
    {
        $isJsonRequest = isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;
        
        if ($isJsonRequest) {
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: *');
            header('Access-Control-Allow-Headers: *');
        } else {
            header('Content-Type: text/html; charset=utf-8');
        }
        http_response_code(500);

        $output = [];
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $file = $bt[0]['file'];
        $line = $bt[0]['line'];

        foreach ($vars as $k => $v) {
            $callingCode = file($file);
            preg_match('/dd\s*\((.*?)\)/', $callingCode[$line - 1], $matches);
            $varNames = array_map('trim', explode(',', $matches[1] ?? ''));
            
            $output[] = [
                'nombre' => $varNames[$k] ?? "Variable #" . ($k + 1),
                'tipo' => gettype($v),
                'valor' => $v
            ];
        }

        if ($isJsonRequest) {
            echo json_encode($output, JSON_PRETTY_PRINT);
        } else {
            echo '<!DOCTYPE html><html><head>';
            echo '<style>
                body { 
                    font-family: "SF Mono", Monaco, Menlo, Courier, monospace;
                    background-color: #2d2a2e;
                    color: #fcfcfa;
                    padding: 20px;
                    margin: 0;
                    line-height: 1.6;
                }
                .debug-container {
                    max-width: 1200px;
                    margin: 0 auto;
                }
                .debug-header {
                    background-color: #403e41;
                    padding: 15px;
                    border-radius: 6px;
                    margin-bottom: 20px;
                }
                .debug-header h2 {
                    margin: 0;
                    color: #78dce8;
                }
                .file-info {
                    color: #ab9df2;
                    font-size: 0.9em;
                    margin: 10px 0 0 0;
                }
                .debug-item {
                    background-color: #403e41;
                    margin-bottom: 20px;
                    border-radius: 6px;
                    overflow: hidden;
                }
                .var-header {
                    padding: 10px 15px;
                    background-color: #2d2a2e;
                    border-bottom: 1px solid #5b595c;
                }
                .var-name {
                    color: #ff6188;
                    font-weight: bold;
                }
                .var-type {
                    color: #a9dc76;
                    font-size: 0.9em;
                }
                pre {
                    background: #2d2a2e;
                    padding: 15px;
                    margin: 0;
                    overflow-x: auto;
                    color: #fcfcfa;
                }
            </style>';
            echo '</head><body>';
            echo '<div class="debug-container">';
            echo '<div class="debug-header">';
            echo "<h2>Debug Information</h2>";
            echo "<p class='file-info'>File: {$file}<br>Line: {$line}</p>";
            echo '</div>';
            
            foreach ($output as $item) {
                echo '<div class="debug-item">';
                echo "<div class='var-header'>";
                echo "<span class='var-name'>{$item['nombre']}</span> ";
                echo "<span class='var-type'>({$item['tipo']})</span>";
                echo "</div>";
                echo '<pre>' . htmlspecialchars(print_r($item['valor'], true)) . '</pre>';
                echo '</div>';
            }
            echo '</div></body></html>';
        }
        die(1);
    }
}   