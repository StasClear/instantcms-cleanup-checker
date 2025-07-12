<?php
/**
 * Полный скрипт проверки удаления файлов InstantCMS
 * Версии: 2.15.0 → 2.17.3
 * Проверяет ВСЕ файлы, которые должны быть удалены после всех обновлений
 * 
 * ВНИМАНИЕ: Удалите этот файл после использования!
 */

// Обработка запросов на удаление
if (isset($_POST['delete_file'])) {
    $file_to_delete = $_POST['delete_file'];
    $response = ['success' => false, 'message' => ''];
    
    if (file_exists($file_to_delete)) {
        if (unlink($file_to_delete)) {
            $response['success'] = true;
            $response['message'] = "Файл $file_to_delete успешно удален!";
        } else {
            $response['message'] = "Ошибка при удалении файла $file_to_delete";
        }
    } else {
        $response['message'] = "Файл $file_to_delete не найден";
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Обработка массового удаления
if (isset($_POST['delete_all'])) {
    $all_files = [
        // 2.15.2
        'readme.txt',
        'system/controllers/images/backend/actions/presets_ajax.php',
        'system/controllers/tags/backend/actions/ajax.php',
        'system/controllers/users/backend/actions/fields_ajax.php',
        'system/controllers/users/backend/actions/migrations_ajax.php',
        'system/controllers/users/backend/actions/tabs_ajax.php',
        'system/controllers/users/hooks/user_loaded.php',
        'templates/admincoreui/controllers/images/backend/presets.tpl.php',
        'templates/admincoreui/controllers/rss/backend/index.tpl.php',
        'templates/admincoreui/controllers/tags/backend/tags.tpl.php',
        'templates/admincoreui/controllers/users/backend/fields.tpl.php',
        'templates/admincoreui/controllers/users/backend/migrations.tpl.php',
        'templates/admincoreui/controllers/users/backend/tabs.tpl.php',
        'templates/admincoreui/controllers/wysiwygs/backend/presets.tpl.php',
        'templates/default/controllers/images/backend/presets.tpl.php',
        'templates/default/controllers/rss/backend/index.tpl.php',
        'templates/default/controllers/tags/backend/tags.tpl.php',
        'templates/default/controllers/users/backend/fields.tpl.php',
        'templates/default/controllers/users/backend/migrations.tpl.php',
        'templates/default/controllers/users/backend/tabs.tpl.php',
        'templates/default/controllers/wysiwygs/backend/presets.tpl.php',
        
        // 2.16.0
        'system/controllers/admin/actions/content_grid_columns.php',
        'system/controllers/admin/actions/content_items_ajax.php',
        'system/controllers/admin/actions/controllers_ajax.php',
        'system/controllers/admin/actions/controllers_events_ajax.php',
        'system/controllers/admin/actions/ctypes_ajax.php',
        'system/controllers/admin/actions/ctypes_datasets_reorder.php',
        'system/controllers/admin/actions/ctypes_datasets_toggle.php',
        'system/controllers/admin/actions/ctypes_fields_ajax.php',
        'system/controllers/admin/actions/ctypes_props_ajax.php',
        'system/controllers/admin/actions/ctypes_relations_reorder.php',
        'system/controllers/admin/actions/menu_item_toggle.php',
        'system/controllers/admin/actions/menu_items_ajax.php',
        'system/controllers/admin/actions/menu_items_reorder.php',
        'system/controllers/admin/actions/settings_scheduler_ajax.php',
        'system/controllers/admin/actions/settings_scheduler_toggle.php',
        'system/controllers/admin/hooks/grid_admin_content_items_args.php',
        'system/controllers/admin/traits/listgrid.php',
        'system/controllers/comments/backend/actions/comments_list.php',
        'system/controllers/forms/backend/actions/fields_reorder.php',
        'system/controllers/geo/backend/actions/cities_reorder.php',
        'system/controllers/geo/backend/actions/countries_reorder.php',
        'system/controllers/geo/backend/actions/regions_reorder.php',
        'system/controllers/groups/backend/actions/fields.php',
        'system/controllers/groups/backend/actions/fields_reorder.php',
        'system/controllers/tags/actions/search.php',
        'system/controllers/users/backend/actions/fields_reorder.php',
        'system/controllers/users/backend/actions/tabs_reorder.php',
        'system/libs/mimetypes.php',
        'system/libs/timezones.php',
        'templates/admincoreui/assets/ui/grid-data.tpl.php',
        'templates/admincoreui/controllers/admin/content_filter.tpl.php',
        'templates/admincoreui/controllers/admin/content_grid_columns.tpl.php',
        'templates/admincoreui/controllers/admin/controllers.tpl.php',
        'templates/admincoreui/controllers/admin/ctypes.tpl.php',
        'templates/admincoreui/controllers/admin/ctypes_datasets.tpl.php',
        'templates/admincoreui/controllers/admin/ctypes_fields.tpl.php',
        'templates/admincoreui/controllers/admin/ctypes_filters.tpl.php',
        'templates/admincoreui/controllers/admin/ctypes_relations.tpl.php',
        'templates/admincoreui/controllers/admin/settings_scheduler.tpl.php',
        'templates/admincoreui/controllers/admin/users_filter.tpl.php',
        'templates/admincoreui/controllers/comments/backend/comments_list.tpl.php',
        'templates/admincoreui/controllers/forms/backend/form_fields.tpl.php',
        'templates/admincoreui/controllers/forms/backend/index.tpl.php',
        'templates/admincoreui/controllers/geo/backend/cities.tpl.php',
        'templates/admincoreui/controllers/geo/backend/countries.tpl.php',
        'templates/admincoreui/controllers/geo/backend/regions.tpl.php',
        'templates/admincoreui/controllers/groups/backend/datasets.tpl.php',
        'templates/admincoreui/controllers/groups/backend/fields.tpl.php',
        'templates/admincoreui/controllers/subscriptions/backend/subscriptions.tpl.php',
        'templates/default/controllers/admin/content_filter.tpl.php',
        'templates/default/controllers/admin/content_grid_columns.tpl.php',
        'templates/default/controllers/admin/controllers.tpl.php',
        'templates/default/controllers/admin/ctypes.tpl.php',
        'templates/default/controllers/admin/ctypes_datasets.tpl.php',
        'templates/default/controllers/admin/ctypes_filters.tpl.php',
        'templates/default/controllers/admin/ctypes_relations.tpl.php',
        'templates/default/controllers/admin/settings_scheduler.tpl.php',
        'templates/default/controllers/comments/backend/comments_list.tpl.php',
        'templates/default/controllers/forms/backend/form_fields.tpl.php',
        'templates/default/controllers/forms/backend/index.tpl.php',
        'templates/default/controllers/geo/backend/cities.tpl.php',
        'templates/default/controllers/geo/backend/countries.tpl.php',
        'templates/default/controllers/geo/backend/regions.tpl.php',
        'templates/default/controllers/groups/backend/datasets.tpl.php',
        'templates/default/controllers/groups/backend/fields.tpl.php',
        'templates/default/controllers/subscriptions/backend/subscriptions.tpl.php',
        'templates/default/controllers/users/backend/migration.tpl.php',
        'templates/default/controllers/users/backend/tab.tpl.php',
        'templates/modern/js/datagrid-pagination.js',
        
        // 2.17.0
        'system/controllers/groups/actions/group_closed.php',
        'system/libs/phpmailer/language/phpmailer.lang-am.php',
        'system/libs/phpmailer/language/phpmailer.lang-ch.php',
        'system/libs/phpmailer/language/phpmailer.lang-rs.php',
        'system/libs/phpmailer/class.phpmailer.php',
        'system/libs/phpmailer/class.pop3.php',
        'system/libs/phpmailer/class.smtp.php',
        'system/libs/scssphp/scss.inc.php',
        'templates/default/controllers/groups/group_closed.tpl.php',
        'templates/modern/controllers/groups/group_closed.tpl.php',
        
        // 2.17.1
        'system/core/cachememory.php'
    ];
    
    $deleted_count = 0;
    $errors = [];
    
    foreach ($all_files as $file) {
        if (file_exists($file)) {
            if (unlink($file)) {
                $deleted_count++;
            } else {
                $errors[] = $file;
            }
        }
    }
    
    $response = [
        'success' => true,
        'deleted_count' => $deleted_count,
        'errors' => $errors,
        'message' => "Удалено файлов: $deleted_count" . (count($errors) > 0 ? ", ошибки: " . count($errors) : "")
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Полная проверка файлов InstantCMS 2.15.0 - 2.17.3</title>";
echo "<style>
body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
.container { max-width: 1400px; margin: 0 auto; background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; }
.header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
.header h1 { margin: 0; font-size: 2.5em; font-weight: 300; }
.version-badge { background: rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 25px; display: inline-block; margin: 15px 0; backdrop-filter: blur(10px); }
.content { padding: 30px; }
.summary { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 25px; margin: 25px 0; border-radius: 12px; border-left: 5px solid #2196f3; }
.version-section { margin: 30px 0; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
.version-header { background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%); color: white; padding: 20px; font-weight: bold; font-size: 1.2em; display: flex; justify-content: space-between; align-items: center; }
.version-content { padding: 20px; background: #fafafa; }
.file-item { margin: 8px 0; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease; border-left: 4px solid transparent; }
.file-exists { background: linear-gradient(135deg, #ffebee 0%, #fce4ec 100%); border-left-color: #f44336; }
.file-deleted { background: linear-gradient(135deg, #e8f5e8 0%, #f1f8e9 100%); border-left-color: #4caf50; }
.file-critical { border-left-width: 6px; border-left-color: #d32f2f !important; box-shadow: 0 2px 8px rgba(211,47,47,0.3); }
.file-path { flex: 1; }
.file-status { font-weight: bold; }
.status-exists { color: #d32f2f; }
.status-deleted { color: #2e7d32; }
.delete-btn { background: linear-gradient(45deg, #f44336, #ff5722); color: white; border: none; padding: 10px 20px; border-radius: 25px; cursor: pointer; font-size: 12px; font-weight: bold; transition: all 0.3s ease; }
.delete-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(244,67,54,0.4); }
.delete-btn:disabled { background: #ccc; cursor: not-allowed; transform: none; box-shadow: none; }
.delete-all-btn { background: linear-gradient(45deg, #ff5722, #ff7043); color: white; border: none; padding: 15px 30px; border-radius: 30px; cursor: pointer; font-size: 16px; font-weight: bold; margin: 20px 10px; transition: all 0.3s ease; }
.delete-all-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(255,87,34,0.4); }
.refresh-btn { background: linear-gradient(45deg, #2196f3, #21cbf3); color: white; border: none; padding: 12px 25px; border-radius: 25px; cursor: pointer; margin: 10px; transition: all 0.3s ease; }
.refresh-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(33,150,243,0.4); }
.progress { width: 100%; height: 30px; background: #e0e0e0; border-radius: 15px; overflow: hidden; margin: 20px 0; position: relative; }
.progress-bar { height: 100%; background: linear-gradient(45deg, #4caf50, #66bb6a); transition: width 0.5s ease; }
.progress-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; color: #333; z-index: 1; }
.message { padding: 15px; border-radius: 8px; margin: 15px 0; font-weight: bold; animation: slideIn 0.3s ease; }
.success { background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; border: 2px solid #c3e6cb; }
.error { background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); color: #721c24; border: 2px solid #f5c6cb; }
.icon { font-size: 1.2em; margin-right: 8px; }
.critical-badge { background: #d32f2f; color: white; padding: 3px 8px; border-radius: 12px; font-size: 10px; margin-left: 10px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0; }
.stat-card { background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
.stat-number { font-size: 2em; font-weight: bold; margin-bottom: 5px; }
.stat-label { color: #666; font-size: 0.9em; }
@keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
@media (max-width: 768px) { 
    .file-item { flex-direction: column; align-items: flex-start; gap: 10px; }
    .header h1 { font-size: 2em; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
}
</style></head><body>";

echo "<div class='container'>";
echo "<div class='header'>";
echo "<h1>🔍 Полная проверка файлов InstantCMS</h1>";
echo "<div class='version-badge'>Версии 2.15.0 → 2.17.3 • Все обновления</div>";
echo "<p>Проверка ВСЕХ файлов, которые должны быть удалены после обновлений</p>";
echo "</div>";

echo "<div class='content'>";

// Определяем текущую версию
$version = 'unknown';
$version_file = 'system/config/version.php';
if (file_exists($version_file)) {
    $content = file_get_contents($version_file);
    if (preg_match('/["\']version["\']\s*=>\s*["\']([^"\']+)/', $content, $matches)) {
        $version = $matches[1];
    }
}

// Все файлы по версиям
$files_by_versions = [
    '2.15.2 (30 июня 2022)' => [
        'critical' => ['system/controllers/users/hooks/user_loaded.php'],
        'files' => [
            'readme.txt',
            'system/controllers/images/backend/actions/presets_ajax.php',
            'system/controllers/tags/backend/actions/ajax.php',
            'system/controllers/users/backend/actions/fields_ajax.php',
            'system/controllers/users/backend/actions/migrations_ajax.php',
            'system/controllers/users/backend/actions/tabs_ajax.php',
            'templates/admincoreui/controllers/images/backend/presets.tpl.php',
            'templates/admincoreui/controllers/rss/backend/index.tpl.php',
            'templates/admincoreui/controllers/tags/backend/tags.tpl.php',
            'templates/admincoreui/controllers/users/backend/fields.tpl.php',
            'templates/admincoreui/controllers/users/backend/migrations.tpl.php',
            'templates/admincoreui/controllers/users/backend/tabs.tpl.php',
            'templates/admincoreui/controllers/wysiwygs/backend/presets.tpl.php',
            'templates/default/controllers/images/backend/presets.tpl.php',
            'templates/default/controllers/rss/backend/index.tpl.php',
            'templates/default/controllers/tags/backend/tags.tpl.php',
            'templates/default/controllers/users/backend/fields.tpl.php',
            'templates/default/controllers/users/backend/migrations.tpl.php',
            'templates/default/controllers/users/backend/tabs.tpl.php',
            'templates/default/controllers/wysiwygs/backend/presets.tpl.php'
        ],
        'actions' => ['Обновить события в админке (обязательно!)']
    ],
    
    '2.16.0 (13 июня 2023)' => [
        'critical' => ['system/controllers/admin/hooks/grid_admin_content_items_args.php'],
        'files' => [
            'system/controllers/admin/actions/content_grid_columns.php',
            'system/controllers/admin/actions/content_items_ajax.php',
            'system/controllers/admin/actions/controllers_ajax.php',
            'system/controllers/admin/actions/controllers_events_ajax.php',
            'system/controllers/admin/actions/ctypes_ajax.php',
            'system/controllers/admin/actions/ctypes_datasets_reorder.php',
            'system/controllers/admin/actions/ctypes_datasets_toggle.php',
            'system/controllers/admin/actions/ctypes_fields_ajax.php',
            'system/controllers/admin/actions/ctypes_props_ajax.php',
            'system/controllers/admin/actions/ctypes_relations_reorder.php',
            'system/controllers/admin/actions/menu_item_toggle.php',
            'system/controllers/admin/actions/menu_items_ajax.php',
            'system/controllers/admin/actions/menu_items_reorder.php',
            'system/controllers/admin/actions/settings_scheduler_ajax.php',
            'system/controllers/admin/actions/settings_scheduler_toggle.php',
            'system/controllers/admin/traits/listgrid.php',
            'system/controllers/comments/backend/actions/comments_list.php',
            'system/controllers/forms/backend/actions/fields_reorder.php',
            'system/controllers/geo/backend/actions/cities_reorder.php',
            'system/controllers/geo/backend/actions/countries_reorder.php',
            'system/controllers/geo/backend/actions/regions_reorder.php',
            'system/controllers/groups/backend/actions/fields.php',
            'system/controllers/groups/backend/actions/fields_reorder.php',
            'system/controllers/tags/actions/search.php',
            'system/controllers/users/backend/actions/fields_reorder.php',
            'system/controllers/users/backend/actions/tabs_reorder.php',
            'system/libs/mimetypes.php',
            'system/libs/timezones.php',
            'templates/admincoreui/assets/ui/grid-data.tpl.php',
            'templates/admincoreui/controllers/admin/content_filter.tpl.php',
            'templates/admincoreui/controllers/admin/content_grid_columns.tpl.php',
            'templates/admincoreui/controllers/admin/controllers.tpl.php',
            'templates/admincoreui/controllers/admin/ctypes.tpl.php',
            'templates/admincoreui/controllers/admin/ctypes_datasets.tpl.php',
            'templates/admincoreui/controllers/admin/ctypes_fields.tpl.php',
            'templates/admincoreui/controllers/admin/ctypes_filters.tpl.php',
            'templates/admincoreui/controllers/admin/ctypes_relations.tpl.php',
            'templates/admincoreui/controllers/admin/settings_scheduler.tpl.php',
            'templates/admincoreui/controllers/admin/users_filter.tpl.php',
            'templates/admincoreui/controllers/comments/backend/comments_list.tpl.php',
            'templates/admincoreui/controllers/forms/backend/form_fields.tpl.php',
            'templates/admincoreui/controllers/forms/backend/index.tpl.php',
            'templates/admincoreui/controllers/geo/backend/cities.tpl.php',
            'templates/admincoreui/controllers/geo/backend/countries.tpl.php',
            'templates/admincoreui/controllers/geo/backend/regions.tpl.php',
            'templates/admincoreui/controllers/groups/backend/datasets.tpl.php',
            'templates/admincoreui/controllers/groups/backend/fields.tpl.php',
            'templates/admincoreui/controllers/subscriptions/backend/subscriptions.tpl.php',
            'templates/default/controllers/admin/content_filter.tpl.php',
            'templates/default/controllers/admin/content_grid_columns.tpl.php',
            'templates/default/controllers/admin/controllers.tpl.php',
            'templates/default/controllers/admin/ctypes.tpl.php',
            'templates/default/controllers/admin/ctypes_datasets.tpl.php',
            'templates/default/controllers/admin/ctypes_filters.tpl.php',
            'templates/default/controllers/admin/ctypes_relations.tpl.php',
            'templates/default/controllers/admin/settings_scheduler.tpl.php',
            'templates/default/controllers/comments/backend/comments_list.tpl.php',
            'templates/default/controllers/forms/backend/form_fields.tpl.php',
            'templates/default/controllers/forms/backend/index.tpl.php',
            'templates/default/controllers/geo/backend/cities.tpl.php',
            'templates/default/controllers/geo/backend/countries.tpl.php',
            'templates/default/controllers/geo/backend/regions.tpl.php',
            'templates/default/controllers/groups/backend/datasets.tpl.php',
            'templates/default/controllers/groups/backend/fields.tpl.php',
            'templates/default/controllers/subscriptions/backend/subscriptions.tpl.php',
            'templates/default/controllers/users/backend/migration.tpl.php',
            'templates/default/controllers/users/backend/tab.tpl.php',
            'templates/modern/js/datagrid-pagination.js'
        ],
        'actions' => ['Обновить события в админке (обязательно!)', 'Минимальная версия PHP: 7.0']
    ],
    
    '2.17.0 (27 декабря 2024)' => [
        'critical' => [],
        'files' => [
            'system/controllers/groups/actions/group_closed.php',
            'system/libs/phpmailer/language/phpmailer.lang-am.php',
            'system/libs/phpmailer/language/phpmailer.lang-ch.php',
            'system/libs/phpmailer/language/phpmailer.lang-rs.php',
            'system/libs/phpmailer/class.phpmailer.php',
            'system/libs/phpmailer/class.pop3.php',
            'system/libs/phpmailer/class.smtp.php',
            'system/libs/scssphp/scss.inc.php',
            'templates/default/controllers/groups/group_closed.tpl.php',
            'templates/modern/controllers/groups/group_closed.tpl.php'
        ],
        'actions' => ['Минимальная версия PHP: 7.2.0', 'Новый компонент CSP', 'Кастомизация сборок']
    ],
    
    '2.17.1 (11 января 2025)' => [
        'critical' => [],
        'files' => [
            'system/core/cachememory.php'
        ],
        'actions' => ['Поддержка Redis для кэширования']
    ]
];

// Подсчитываем статистику
$total_files = 0;
$existing_files = 0;
$critical_existing = 0;
$deleted_files = 0;

foreach ($files_by_versions as $ver => $data) {
    $all_files = array_merge($data['critical'], $data['files']);
    foreach ($all_files as $file) {
        $total_files++;
        if (file_exists($file)) {
            $existing_files++;
            if (in_array($file, $data['critical'])) {
                $critical_existing++;
            }
        } else {
            $deleted_files++;
        }
    }
}

$completion_percent = $total_files > 0 ? round(($deleted_files / $total_files) * 100, 1) : 100;

// Показываем общую статистику
echo "<div class='summary'>";
echo "<h3>📊 Общая статистика всех обновлений:</h3>";

echo "<div class='stats-grid'>";
echo "<div class='stat-card'><div class='stat-number' style='color: #2196f3;'>$total_files</div><div class='stat-label'>Всего файлов</div></div>";
echo "<div class='stat-card'><div class='stat-number' style='color: #f44336;'>$existing_files</div><div class='stat-label'>Требуют удаления</div></div>";
echo "<div class='stat-card'><div class='stat-number' style='color: #4caf50;'>$deleted_files</div><div class='stat-label'>Уже удалены</div></div>";
echo "<div class='stat-card'><div class='stat-number' style='color: #ff9800;'>$critical_existing</div><div class='stat-label'>Критичных</div></div>";
echo "</div>";

echo "<div class='progress'>";
echo "<div class='progress-bar' style='width: $completion_percent%;'></div>";
echo "<div class='progress-text'>$completion_percent% завершено</div>";
echo "</div>";

echo "<p><strong>Текущая версия InstantCMS:</strong> $version</p>";

if ($existing_files > 0) {
    echo "<button class='delete-all-btn' onclick='deleteAllFiles()'>";
    echo "<span class='icon'>🗑️</span>УДАЛИТЬ ВСЕ НАЙДЕННЫЕ ФАЙЛЫ ($existing_files шт.)";
    echo "</button>";
} else {
    echo "<div style='background: linear-gradient(135deg, #4caf50, #66bb6a); color: white; padding: 25px; border-radius: 12px; text-align: center; font-size: 1.2em; font-weight: bold;'>";
    echo "🎉 ПРЕВОСХОДНО! Все файлы удалены. Система полностью очищена!";
    echo "</div>";
}

echo "<button class='refresh-btn' onclick='location.reload()'>";
echo "<span class='icon'>🔄</span>Обновить проверку";
echo "</button>";
echo "</div>";

if ($critical_existing > 0) {
    echo "<div style='background: linear-gradient(135deg, #ffebee, #fce4ec); padding: 20px; margin: 20px 0; border-radius: 12px; border: 2px solid #f44336;'>";
    echo "<h4 style='color: #d32f2f; margin: 0 0 10px 0;'>🔥 КРИТИЧЕСКОЕ ПРЕДУПРЕЖДЕНИЕ!</h4>";
    echo "<p style='margin: 0; color: #721c24;'>Найдены критичные файлы: <strong>$critical_existing шт.</strong> Эти файлы могут вызывать серьезные ошибки!</p>";
    echo "</div>";
}

// Показываем файлы по версиям
foreach ($files_by_versions as $version_name => $data) {
    $version_files = array_merge($data['critical'], $data['files']);
    $version_existing = 0;
    $version_critical = 0;
    
    foreach ($version_files as $file) {
        if (file_exists($file)) {
            $version_existing++;
            if (in_array($file, $data['critical'])) {
                $version_critical++;
            }
        }
    }
    
    $version_status = $version_existing == 0 ? '✅ Все файлы удалены' : "❌ Найдено файлов: $version_existing";
    $status_color = $version_existing == 0 ? '#4caf50' : '#f44336';
    
    echo "<div class='version-section'>";
    echo "<div class='version-header'>";
    echo "<span>📦 InstantCMS $version_name</span>";
    echo "<span style='background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 15px; font-size: 0.9em;'>$version_status</span>";
    echo "</div>";
    echo "<div class='version-content'>";
    
    if (!empty($data['actions'])) {
        echo "<div style='background: linear-gradient(135deg, #fff3e0, #fce4ec); padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ff9800;'>";
        echo "<h4 style='margin: 0 0 10px 0; color: #f57c00;'>📋 Важные изменения в этой версии:</h4>";
        echo "<ul style='margin: 0; padding-left: 20px;'>";
        foreach ($data['actions'] as $action) {
            echo "<li style='margin: 5px 0; color: #bf360c;'>$action</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
    
    // Критичные файлы отдельно
    if (!empty($data['critical'])) {
        echo "<h4 style='color: #d32f2f; margin: 20px 0 10px 0;'>🔥 Критичные файлы (ОБЯЗАТЕЛЬНО удалить!):</h4>";
        foreach ($data['critical'] as $file) {
            $exists = file_exists($file);
            $class = $exists ? 'file-exists file-critical' : 'file-deleted';
            $status_class = $exists ? 'status-exists' : 'status-deleted';
            $status = $exists ? '❌ КРИТИЧНО - УДАЛИТЬ!' : '✅ УДАЛЕН';
            
            echo "<div class='file-item $class'>";
            echo "<div class='file-path'>";
            echo "<span class='file-status $status_class'>$status</span>";
            echo "<br><code style='font-size: 0.9em; color: #666;'>$file</code>";
            if ($exists) {
                echo "<span class='critical-badge'>КРИТИЧНО</span>";
            }
            echo "</div>";
            if ($exists) {
                echo "<button class='delete-btn' onclick='deleteFile(\"$file\", this)'>";
                echo "<span class='icon'>🗑️</span>Удалить";
                echo "</button>";
            }
            echo "</div>";
        }
    }
    
    // Обычные файлы
    if (!empty($data['files'])) {
        echo "<h4 style='color: #1976d2; margin: 20px 0 10px 0;'>📄 Обычные файлы:</h4>";
        foreach ($data['files'] as $file) {
            $exists = file_exists($file);
            $class = $exists ? 'file-exists' : 'file-deleted';
            $status_class = $exists ? 'status-exists' : 'status-deleted';
            $status = $exists ? '⚠️ НУЖНО УДАЛИТЬ' : '✅ УДАЛЕН';
            
            echo "<div class='file-item $class'>";
            echo "<div class='file-path'>";
            echo "<span class='file-status $status_class'>$status</span>";
            echo "<br><code style='font-size: 0.9em; color: #666;'>$file</code>";
            echo "</div>";
            if ($exists) {
                echo "<button class='delete-btn' onclick='deleteFile(\"$file\", this)'>";
                echo "<span class='icon'>🗑️</span>Удалить";
                echo "</button>";
            }
            echo "</div>";
        }
    }
    
    echo "</div>";
    echo "</div>";
}

// Финальные инструкции
echo "<div style='background: linear-gradient(135deg, #f3e5f5, #e8eaf6); padding: 25px; border-radius: 12px; margin: 30px 0;'>";
echo "<h3 style='color: #673ab7; margin: 0 0 15px 0;'>✅ После удаления всех файлов:</h3>";
echo "<ol style='margin: 0; padding-left: 20px; line-height: 1.8;'>";
echo "<li><strong>Обновите события в админке:</strong> Настройки → Управление компонентами → Обновить события</li>";
echo "<li><strong>Очистите кэш:</strong> Настройки → Производительность → Очистить весь кэш</li>";
echo "<li><strong>Увеличьте абстрактный счетчик</strong> на +1 для сброса кэша браузера</li>";
echo "<li><strong>Проверьте работу сайта</strong> - создайте тестовую запись</li>";
echo "<li><strong>Удалите этот файл проверки!</strong> (Важно для безопасности)</li>";
echo "</ol>";
echo "</div>";

// JavaScript
echo "<script>
function deleteFile(filename, button) {
    if(!confirm('Удалить файл: ' + filename + '?')) return;
    
    button.disabled = true;
    button.innerHTML = '<span class=\"icon\">⏳</span>Удаляю...';
    
    fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'delete_file=' + encodeURIComponent(filename)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showMessage(data.message, 'success');
            button.closest('.file-item').style.opacity = '0.5';
            button.closest('.file-item').style.transform = 'scale(0.95)';
            setTimeout(() => location.reload(), 1500);
        } else {
            showMessage(data.message, 'error');
            button.disabled = false;
            button.innerHTML = '<span class=\"icon\">🗑️</span>Удалить';
        }
    })
    .catch(error => {
        showMessage('Ошибка: ' + error, 'error');
        button.disabled = false;
        button.innerHTML = '<span class=\"icon\">🗑️</span>Удалить';
    });
}

function deleteAllFiles() {
    if(!confirm('⚠️ ВНИМАНИЕ!\\n\\nВы собираетесь удалить ВСЕ найденные файлы из всех версий InstantCMS.\\n\\nЭто действие нельзя отменить!\\n\\nПродолжить?')) return;
    
    const button = document.querySelector('.delete-all-btn');
    button.disabled = true;
    button.innerHTML = '<span class=\"icon\">⏳</span>Удаляю все файлы...';
    
    fetch('', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'delete_all=1'
    })
    .then(response => response.json())
    .then(data => {
        showMessage(data.message, data.success ? 'success' : 'error');
        setTimeout(() => location.reload(), 2500);
    })
    .catch(error => {
        showMessage('Ошибка: ' + error, 'error');
        button.disabled = false;
        button.innerHTML = '<span class=\"icon\">🗑️</span>Удалить все файлы';
    });
}

function showMessage(text, type) {
    const div = document.createElement('div');
    div.className = 'message ' + type;
    div.innerHTML = '<span class=\"icon\">' + (type === 'success' ? '✅' : '❌') + '</span>' + text;
    document.querySelector('.content').insertBefore(div, document.querySelector('.content').firstChild);
    setTimeout(() => div.remove(), 6000);
}
</script>";

echo "<footer style='text-align: center; padding: 30px; color: #666; border-top: 1px solid #eee; margin-top: 40px;'>";
echo "<p style='margin: 0; font-size: 0.9em;'>🎯 InstantCMS Full Cleanup Checker v2.0 • " . date('d.m.Y H:i:s') . "</p>";
echo "<p style='margin: 5px 0 0 0; font-size: 0.8em;'>Проверка файлов для версий 2.15.0 - 2.17.3 • Удалите этот файл после использования!</p>";
echo "</footer>";

echo "</div>";
echo "</div>";
echo "</body></html>";