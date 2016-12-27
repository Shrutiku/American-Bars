
node {
	if (env.ENV_NAME == 'sandbox') {
            build '../../userContent/devops/Jenkins.sandbox'
        } else if (env.ENV_NAME == 'stage') {
            build '../../userContent/devops/Jenkins.stage'
        } else if (env.ENV_NAME == 'prod') {
            build '../../userContent/devops/Jenkins.prod'
        }
}