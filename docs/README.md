## Creating a new site umbrella repository using this repository

This is referenced in the instructions for creating a new site and umbrella repository at https://github.com/INN/docs/blob/master/projects/largo/umbrella-create-new-repo.md and covers the creation of the new umbrella repository.

Using `sitename.org` as an example, and providing full pathnames in front of command-line prompts to help keep you located:

1. When running `vv create` or `yo wp` or `wp config create; wp core install`, make notes of the answers you provide to the script.
2. From the directory above the wordpress installation, run `ls`. You should see something that looks like this:

	In vvv:

	```
	/vagrant-local/www/sitename-org$ ls
	htdocs/      vvv-hosts    vvv-init.sh  wp-cli.yml
	```
	In Valet:
	
	```
	~/sites$ ls  
	a-valet-site/  
	another-valet-site/  
	```
3. Clone this repository to someplace safe:

	In vvv:

	```
	/vagrant-local/www/sitename-org$ git clone git@github.com:INN/umbrella-boilerplate.git /tmp/umbrella-boilerplate
	```
	In Valet:
	
	```
	~/sites$ git clone git@github.com:INN/umbrella-boilerplate.git /tmp/umbrella-boilerplate
	```
4. Copy this repository's contents to your new site:

	In vvv:

	```
	/vagrant-local/www/sitename-org$ rsync -rv --exclude=.git /tmp/umbrella-boilerplate/ htdocs/
	```
	In Valet:
	
	```
	~/sites$ mkdir sitename-org
	~/sites$ rsync -rv --exclude=.git /tmp/umbrella-boilerplate/ sitename-org
	```
5. Make sure that the contents were copied by comparing the new install and the umbrella repo's contents
	
	In vvv:
	
	```
	/vagrant-local/www/sitename-org$ ls /tmp/umbrella-boilerplate
	/vagrant-local/www/sitename-org$ ls htdocs/
	```
	In Valet:
	
	```
	~/sites$ ls /tmp/umbrella-boilerplate
	~/sites$ ls sitename-org
	```
6. Now, initialize the submodules and do some other things.
	
	In vvv:

	```
	/vagrant-local/www/sitename-org$ cd htdocs
	/vagrant-local/www/sitename-org/htdocs$ git init
	/vagrant-local/www/sitename-org/htdocs$ ./initialize.sh
	/vagrant-local/www/sitename-org/htdocs$ git status
	On branch master
	Changes to be committed:
	  (use "git reset HEAD <file>..." to unstage)

		new file:   .git-ftp-ignore
		new file:   .gitignore
		new file:   .gitmodules
		new file:   README.md
		new file:   wp-content/themes/largo

	```
	In Valet:
	
	```
	~/sites$ cd sitename-org
	~/sites/sitename-org$ git init
	~/sites/sitename-org$ ./initialize.sh
	~/sites/sitename-org$ git status
	On branch master
	Changes to be committed:
	  (use "git reset HEAD <file>..." to unstage)

		new file:   .git-ftp-ignore
		new file:   .gitignore
		new file:   .gitmodules
		new file:   README.md
		new file:   wp-content/themes/largo

	```
	
	Note that that will remove the initialize.sh script and this README file.

7. Copy in the child theme, if necessary.
	1. `cd wp-content/themes/`
	2. `git clone git@bitbucket.org:projectlargo/theme-c-hit.git c-hit`: note the second argument to `git clone` specifying where to clone into
	3. `rm -r c-hit/.git`: remove the .git directory from the child theme, making it no longer a git repository, but just a bunch of files
	4. Edit the child theme's `style.css` has `Template: largo` and not `Template: largo-dev`. [Edit the file](https://github.com/INN/umbrella-nhindepth/commit/1434e83c9f2461625b76395710ee840322a55d86) if necessary. If this changes, make note of this fact, because that may require change or updates to configuration options in the site's database.
	5. `cd ../../` : go back to the root of the project

8. Edit files to reflect the appropriate variables for this installation:
	- `README.md` - perform find-and-replace with domain name, but also check the instructions from the `vv create` setup
	- `.gitignore` - see comment at bottom of file; you need to add the child theme's directory name here

9. Prepare to commit: use `git add` to add the child theme and any other files.
	- Note that the child theme is not a submodule in this setup - we are incorporating the files directly into the theme. If you don't see individual files within the child theme from the umbrella repository when you're running `git add`, something has gone wrong.

10. Commit: `git commit`


This doesn't set any variables. This doesn't fill out any text. This just gets you the files.

If this repo is hosted on an account owned by INN, add [client-hosting-manager](https://github.com/INN/client-hosting-manager) as a submodule in `wp-content/plugins/client-hosting-manager`, and add the required constants to the site's wp-config.php after deploying, but before activating.
