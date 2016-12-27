
node {
	if (env.ENV_NAME == 'sandbox') {
            build '~/userContent/devops/Jenkinsfile.sandbox'
        } else if (env.ENV_NAME == 'stage') {
            build '~/userContent/devops/Jenkinsfile.stage'
        } else if (env.ENV_NAME == 'prod') {
            build '~/userContent/devops/Jenkinsfile.prod'
        }
}
