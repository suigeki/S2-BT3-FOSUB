set :application, "S2-BT3-FOSUB"
set :domain,      "labdev.com"
set :user,        "vagrant"
set :deploy_to,   "E:/Projets/apps"
set :app_path,    "app"
# set :copy_exclude, "log/*"

set :scm          :none
set :local_repository, "."
set :repository,  "."
# set :local_repository, "file:///wamp64/www/symfony2/S2-BT3-FOSUB"
set :deploy_via,  :copy
# set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations

set  :shared_files,         ["app/config/parameters.yml"]
set  :shared_children,      [app_path + "/logs", web_path + "/uploads"]

set  :use_composer, true
set  :update_vendors, true

set  :keep_releases,  3

task :upload_parameters do
  origin_file = "app/config/parameters.yml"
  destination_file = latest_release + "/app/config/parameters.yml" # Notice the latest_release

  try_sudo "mkdir -p #{File.dirname(destination_file)}"
  top.upload(origin_file, destination_file)
end

before "deploy:share_childs", "upload_parameters"

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL