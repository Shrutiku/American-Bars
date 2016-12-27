
node {
	if (env.ENV_NAME == 'sandbox') {
            build job: '/var/lib/jenkins/userContent/devops/Jenkinsfile.sandbox'
        } else if (env.ENV_NAME == 'stage') {
            build job: '/var/lib/jenkins/userContent/devops/Jenkinsfile.stage'
        } else if (env.ENV_NAME == 'prod') {
            build job: '/var/lib/jenkins/userContent/devops/Jenkinsfile.prod'
        }
}
