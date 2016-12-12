
node {
	stage 'Pull Sandbox'
		checkout scm

	stage 'Build Sandbox'
		sh './build-all.php'

	stage 'Deploy Sandbox'
		sh './deploy-sandbox.sh'
}