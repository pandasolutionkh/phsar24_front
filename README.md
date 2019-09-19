Get your local Git repository on Bitbucket
Step 1: Switch to your repository's directory

cd /path/to/your/repo
Step 2: Connect your existing repository to Bitbucket

git remote add origin https://veasnapen@bitbucket.org/veasnapen/school_parttime_front.git
git push -u origin master

#todo compile assets
npm run watch
or yarn watch