
node {
	stage 'Build Sandbox'
		checkout scm
		sh './build-all.sh'

	stage 'Deploy Sandbox'
		sh './deploy_sandbox.sh'
}