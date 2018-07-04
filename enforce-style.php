<?php

    // Detect and save the starting point
    $startingBranch = executeAndLog(
        'git rev-parse --abbrev-ref HEAD',
        'Recording the original working branch'
        );

    // Save a stash of the current state just in case
    executeAndLog(
        'git stash',
        'Stashing the current working branch'
        );

    // Switch branches
    executeAndLog(
        'git checkout phpcs',
        'Switching to PHPCS working branch'
        );

    // Establish a baseline for the branch from master
    executeAndLog(
        'git reset --hard',
        'Resetting PHPCS working branch'
        );

    // Update the working branch from its remote copy
    executeAndLog(
        'git pull',
        'Pulling from remote PHPCS working branch'
        );

    // Update the working branch from master
    executeAndLog(
        'git pull origin master',
        'Updating PHPCS branch from Master'
        );

    // Run the code linter
    executeAndLog(
        'phpcbf --standard=phpcs.xml',
        'Running the PHPCS code linter'
        );

    // Commit the changes
    executeAndLog(
        'git commit -a -m "PHPCS : Automatically enforced style"',
        'Committing the updated code to the PHPCS branch'
        );

    // Push the commit to the server
    executeAndLog(
        'git push --set-upstream origin phpcs',
        'Pushing the PHPCS working branch to remote'
        );

    // Checkout the master branch
    executeAndLog(
        'git checkout master',
        'Switching to the master branch'
        );

    // Make sure we're working with the latest copy of master
    executeAndLog(
        'git pull',
        'Updating the master branch from remote'
        );

    // Merge the commit from the working branch
    executeAndLog(
        'git merge phpcs',
        'Merging the PHPCS branch into the master branch'
        );

    // Add all files changed
    executeAndLog(
        'git add --all',
        'Adding all changed files into the repo'
        );

    // Push the merged master branch to remote
    executeAndLog(
        'git push',
        'Pushing the merged master branch to remote'
        );

    // Return to the original context
    if (isset($startingBranch) && !is_null($startingBranch))
    {
        // Switch back to our working branch
        executeAndLog(
            "git checkout $startingBranch",
            'Switching back to the original working branch'
            );

        // Revert the stash from the beginning
        executeAndLog(
            'git stash apply',
            'Unstash the changes from earlier on this working branch'
            );

        // Update the current working branch with the changes from master (cleaned up styles)
        executeAndLog(
            'git pull',
            'Updating this working branch from the remote working branch'
            );

        executeAndLog(
            'git pull origin master',
            'Update the working branch from the remote master'
            );

        executeAndLog(
            'git push',
            'Update the remote copy of the working branch'
            );
    }

    function executeAndLog($command, $message)
    {
        echo "=== $message...\n";
        echo "::: $command\n";
        $result = `$command`;
        echo "$result\n";
        return $result;
    }