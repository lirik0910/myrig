export default {
	root: document.getElementById('root'),
	body: document.getElementsByTagName('body')[0],
	csrf: document.head.querySelector('[name=csrf-token]').content,
	blank: document.getElementById('blank-default-link')
};