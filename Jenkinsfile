
node {
	stage 'Pull Sandbox'
		checkout scm

	stage 'Build Sandbox'
		sh './build-all'

	stage 'Deploy Sandbox'
		sh './deploy_sandbox.sh'
}