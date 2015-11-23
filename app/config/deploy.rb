set :application,   "Schwabbauer.eu"


task :uberspace do
  set :domain,          "toaotc.carina.uberspace.de"
  set :deploy_to,       "/var/www/virtual/toaotc/schwabbauer_eu"
  role :web,            domain                         # Your HTTP server, Apache/etc
  role :app,            domain, :primary => true       # This may be the same as your `Web` server
  set :user,            "toaotc"
  set :webserver_user,  "toaotc"
end


set :use_sudo,      false
set :app_path,      "app"

set :writable_dirs,       [app_path + "/cache"]
set :permission_method,   :acl
set :use_set_permissions, false

set :repository,  "."
set :deploy_via,  :capifony_copy_local
# set :deploy_via,  :rsync_with_remote_cache
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,   [app_path + "/logs"]

set :use_composer,      true
set :use_composer_tmp,  true

set :keep_releases,     3

task :upload_parameters, :roles => :app do
  capifony_pretty_print "--> Copying parameters.yml to temp location"

  origin_file = "app/config/parameters.yml"
  destination_file = $temp_destination + "/app/config/parameters.yml"

  run_locally "cp #{origin_file} #{destination_file}"
  capifony_puts_ok
end

before "symfony:composer:install", "upload_parameters"

namespace :symfony do
  namespace :assets do
    task :prepare, :roles => :web do
      capifony_pretty_print "--> Installing bower components in temp location"
      run_locally "cd #{$temp_destination} && app/console toa:bower:components:install --env=#{symfony_env_prod} --no-debug"
      capifony_puts_ok
      
      capifony_pretty_print "--> Installing assets in temp location"
      run_locally "cd #{$temp_destination} && app/console assets:install --env=#{symfony_env_prod} --no-debug"
      capifony_puts_ok
      
      capifony_pretty_print "--> Dumping assets in temp location"
      run_locally "cd #{$temp_destination} && app/console assetic:dump --env=#{symfony_env_prod} --no-debug"
      capifony_puts_ok
    end
  end
end

after "symfony:bootstrap:build", "symfony:assets:prepare"

namespace :symfony do
  desc "Clear accelerator cache"
  task :clear_accelerator_cache do
    capifony_pretty_print "--> Clear accelerator cache"
    run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} cache:accelerator:clear #{console_options}'"
    capifony_puts_ok
  end
end

after "deploy", "symfony:clear_accelerator_cache"
after "deploy:rollback:cleanup", "symfony:clear_accelerator_cache"

# logger.level = Logger::MAX_LEVEL
