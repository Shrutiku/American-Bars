
node {
	stage 'Checkout Sandbox'
		checkout scm

	stage 'Build    Sandbox'
		sh './build-all.sh'

	stage 'Deploy   Sandbox'
		sh './deploy_sandbox.sh'
}