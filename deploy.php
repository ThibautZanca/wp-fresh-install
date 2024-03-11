<?php

namespace Deployer;

use Deployer\Task\Context;
use Symfony\Component\Dotenv\Dotenv;
use Closure;

require 'recipe/wordpress.php';
require 'recipe/npm.php';
require 'recipe/dotenv.php';
require 'recipe/sentry.php';

/************************************************
 * A METTRE A JOUR POUR LE DEPLOIEMENT
 * 1. application-name (Nom de votre app)
 * 2. repository_name (nom de votre repo github)
 * 3. Nom du projet dans le host de staging (exemple ici)
 * 4. Mettre à jour le nom du thème (ici lumberjack)
 * ***********************************************/


/************************************************
 *
 *             Set variables
 *
 *************************************************/

// Project name
set('application', 'application-name');

// Project repository
set('repository_name', 'agence-adeliom/repository_name');
set('repository', 'git@github.com:{{repository_name}}.git');


// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);
set('git_cache', true);

// Shared files/dirs between deploys
set('shared_dirs', [
    'web/app/uploads',
    'web/app/_sessions'
]);

// Writable dirs by web server
set('writable_dirs', [
    'web/app/uploads',
    'web/app/_sessions'
]);

set('default_timeout', 0);
set('allow_anonymous_stats', false);

set('project-version', function () {
    $overriddenValues = (new Dotenv())->parse(run('cat {{release_path}}/.env.{{stage}}.local'));
    $version = "1.0.0";
    if (!empty($overriddenValues["APP_VERSION"])) {
        $version = $overriddenValues["APP_VERSION"];
    }
    else {
        $values = (new Dotenv())->parse(run('cat {{release_path}}/.env'));
        if (!empty($values["APP_VERSION"])) {
            $version = $values["APP_VERSION"];
        }
    }
    return $version;
});

set('project-stage', function () {
    return get("stage");
});

/*
// Notify Sentry for release
set('sentry', [
    'organization' => 'adeliom-j1',
    'projects' => ['example-project'],
    'token' => 'sentry-token',
    'version' => get('project-version'),
    'environment' => get('project-stage'),
    'commits' => getCustomGitCommitsRefs()
]);
*/


set('bin/composer', function () {
    run("cd {{release_path}} && curl -sS https://getcomposer.org/installer | {{bin/php}}");
    $composer = '{{bin/php}} {{release_path}}/composer.phar';
    return $composer;
});


/**************************************************
 *
 *              Hosts configuration
 *
 **************************************************/

//Example for staging on adev3.ovh
/*host('staging')
    ->hostname('exemple.adev3.ovh')
    ->user('adev3-ovh')
    //->identityFile("~/.ssh/id_adev3")
    ->port(22)
    ->set('deploy_path', '/var/www/vhosts/adev3.ovh/exemple.adev3.ovh')
    ->set('bin/php', "/opt/plesk/php/7.4/bin/php -d memory_limit=-1")
    ->set('node_path', "/opt/plesk/node/v14.16.1/bin/")
    ->set('export_node_path', true)
    ->set('keep_releases', 3)
    ->set('bin/npm', "{{node_path}}npm --scripts-prepend-node-path=true")
    ->set('composer_action', 'update')
    ->set('composer_options', '{{composer_action}} --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-scripts')
    ->stage('staging')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');
*/

/**************************************************
 *
 *                  TASKS
 *
 **************************************************/

task('npm:build', function () {
    $cmd = "cd {{release_path}}/web/app/themes/lumberjack && {{bin/npm}} run build:production";
    if (get("export_node_path")) {
        $cmd = 'export PATH={{node_path}}:$PATH && ' . $cmd;
    }
    run($cmd);
});


task('npm:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/web/app/themes/lumberjack/node_modules]')) {
            run('cp -R {{previous_release}}/web/app/themes/lumberjack/node_modules {{release_path}}/web/app/themes/lumberjack');
        }
    }
    run('cd {{release_path}}/web/app/themes/lumberjack && {{bin/npm}} install');
});

task('dotenv:set-env', function () {
    run('touch {{release_path}}/.env.local');
    run('echo "APP_ENV={{stage}}" >> {{release_path}}/.env.local');
});

after('dotenv:prepare', 'dotenv:set-env');
after('deploy:update_code', 'deploy:vendors');


after('deploy:update_code', 'npm:install');
after('npm:install', 'npm:build');

// Run Sentry task
//after('deploy', 'deploy:sentry');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


function getCustomGitCommitsRefs(): Closure
{

    return static function ($config = []): array {

        $previousReleaseRevision = null;

        if (has('previous_release')) {
            cd('{{previous_release}}');
            $previousReleaseRevision = trim(run('git rev-parse HEAD'));
        }

        if ($previousReleaseRevision === null) {
            $commitRange = 'HEAD';
        }
        else {
            $commitRange = $previousReleaseRevision . '..HEAD';
        }

        cd('{{release_path}}');
        try {
            $result = run(sprintf('git rev-list --pretty="%s" %s', 'format:%H#%an#%ae#%at', $commitRange));
            $lines = array_filter(
            // limit number of commits for first release with many commits
                array_map('trim', array_slice(explode("\n", $result), 0, 200)),
                static function (string $line): bool {
                    return !empty($line) && strpos($line, 'commit') !== 0;
                }
            );

            return array_map(
                static function (string $line): array {
                    [
                        $ref,
                        $authorName,
                        $authorEmail,
                        $timestamp
                    ] = explode('#', $line);
                    $l = [
                        'id'           => $ref,
                        'author_name'  => $authorName,
                        'author_email' => $authorEmail,
                        'timestamp'    => date(\DateTime::ATOM, (int)$timestamp),
                    ];

                    if ($repo = get("repository_name")) {
                        $l["repository"] = $repo;
                    }
                    return $l;
                },
                $lines
            );

        } catch (\Deployer\Exception\RuntimeException $e) {
            writeln($e->getMessage());
            return [];
        }
    };
}
