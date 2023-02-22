save: save_branch_echo git_add_all git_stash git_checkout git_pull git_stash_pop git_add_all_n_commit git_push

save_branch_echo:
	@${_ECHO} "Saving to branch: '$(or ${WORKING_BRANCH},dev)'"
