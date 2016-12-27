
node {
	if (env.ENV_NAME == 'sandbox') {
            build: '/var/lib/jenkins/userContent/devops/Jenkinsfile.sandbox'
        } else if (env.ENV_NAME == 'stage') {
            build: '/var/lib/jenkins/userContent/devops/Jenkinsfile.stage', wait: True
        } else if (env.ENV_NAME == 'prod') {
            build: '/var/lib/jenkins/userContent/devops/Jenkinsfile.prod'
        }
}
