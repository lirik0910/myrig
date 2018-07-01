const fs = require('fs');
const path = require('path');

const copyFileSync = (source, target) => {
	let targetFile = target;

	if (fs.existsSync(target)) {
		if (fs.lstatSync(target).isDirectory()) {
			targetFile = path.join(target, path.basename(source));
		}
	}
	fs.writeFileSync(targetFile, fs.readFileSync(source));
}

const copyFolderRecursiveSync = (source, target) => {
	let files = [],
		targetFolder = target;

	if (!fs.existsSync(targetFolder)) {
		fs.mkdirSync(targetFolder);
	}

	if (fs.lstatSync(source).isDirectory()) {
		files = fs.readdirSync(source);
		files.forEach((file) => {
			let curSource = path.join(source, file);
			
			if (fs.lstatSync(curSource).isDirectory()) {
				copyFolderRecursiveSync(curSource, targetFolder);
			}
			else {
				copyFileSync(curSource, targetFolder);
			}
		} );
	}
}

fs.readdir('./node_modules/date-fns/', function(err, items) {
	let i = 0,
		a = 0,
		current,
		newName;

	while (i < items.length) {
		current = items[i].split('_');

		if (current.length > 1) {
			newName = ''
			for (a = 0; a < current.length; a++) {
				newName += a === 0 ?
					current[a] :
					current[a].charAt(0).toUpperCase() + current[a].substr(1);
			}

			copyFolderRecursiveSync(
				'./node_modules/date-fns/'+ items[i], 
				'./node_modules/date-fns/'+ newName);
		}
		i++;
	}
});