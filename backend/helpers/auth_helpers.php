<?php
require_once __DIR__ . '/../Controllers/AuthController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Normalise un tableau d'accès pour retourner uniquement les access_name
 */
function normalizeAccessList($list)
{
    if (!is_array($list)) return [];
    if (isset($list[0]) && is_array($list[0]) && isset($list[0]['access_name'])) {
        return array_column($list, 'access_name');
    }
    return $list;
}

/**
 * Charge en session tous les accès de l'utilisateur (nom et section).
 * Structure en session :
 *  - $_SESSION['access_list'] : ['add-student', ...] (liste simple)
 *  - $_SESSION['access_map']  : ['add-student' => true, ...] (lookup rapide)
 *  - $_SESSION['access_sections'] : ['students','personals', ...] (liste de sections)
 *  - $_SESSION['access_by_section'] : ['students' => ['add-student','list-student'], ...]
 */
function loadUserAccessSession(int $user_id)
{
    if (!$user_id) return;

    $auth = new AuthController();
    $rows = $auth->getUserAccessListById($user_id);

    $names = [];
    $map = [];
    $by_section = [];

    if (is_array($rows)) {
        foreach ($rows as $r) {
            if (is_array($r)) {
                $name = $r['access_name'] ?? null;
                $section = $r['access_section'] ?? 'other';
            } else {
                $name = $r;
                $section = 'other';
            }
            if (!$name) continue;
            $names[] = $name;
            $map[$name] = true;
            $by_section[$section][] = $name;
        }
    }

    $_SESSION['access_list'] = array_values(array_unique($names));
    $_SESSION['access_map'] = $map;
    $_SESSION['access_by_section'] = $by_section;
    $_SESSION['access_sections'] = array_values(array_keys($by_section));
}

/**
 * Vérifie si l'utilisateur connecté possède un accès spécifique (par nom)
 */
function hasAccess(string $accessName): bool
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    if (!isset($_SESSION['access_map'])) {
        loadUserAccessSession($_SESSION['user_id']);
    }

    return !empty($_SESSION['access_map'][$accessName]);
}

/**
 * Vérifie si l'utilisateur possède au moins un droit dans la section donnée
 */
function hasSectionAccess(string $section): bool
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    if (!isset($_SESSION['access_by_section'])) {
        loadUserAccessSession($_SESSION['user_id']);
    }

    return isset($_SESSION['access_by_section'][$section]) && count($_SESSION['access_by_section'][$section]) > 0;
}

/**
 * Retourne la liste des sections auxquelles l'utilisateur a accès
 */
function getUserSections(): array
{
    if (!isset($_SESSION['user_id'])) return [];
    if (!isset($_SESSION['access_sections'])) {
        loadUserAccessSession($_SESSION['user_id']);
    }
    return $_SESSION['access_sections'] ?? [];
}
