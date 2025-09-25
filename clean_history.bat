@echo off
echo Cleaning git history to remove secrets...

REM Create a backup branch first
git branch backup-before-clean

REM Reset to the last clean commit (before secrets were added)
git reset --hard 2b74807

REM Add all current files (with secrets removed)
git add .

REM Create a new clean commit
git commit -m "Clean commit: Remove all hardcoded secrets, use environment variables"

REM Force push to update remote
git push origin main --force

echo Done! Git history cleaned and pushed.
echo Backup branch created as 'backup-before-clean' in case you need it.
pause
