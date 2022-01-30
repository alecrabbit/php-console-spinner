save: save_to_branch git_add_all git_stash git_checkout git_pull git_stash_pop git_add_all_n_commit git_push

save_to_branch:
	@echo "Saving to branch: '$(or $(WORKING_BRANCH),dev)'"


