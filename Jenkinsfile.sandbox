
node {
	stage 'Pull Sandbox'
		checkout scm

	stage 'Build Sandbox'
		sh './build-all'

	stage 'Deploy Sandbox'
		sh '/var/lib/jenkins/userContent/devops/deploy_sandbox_webapp.sh'
}