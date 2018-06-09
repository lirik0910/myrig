import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import PaperProduct from '../../components/PaperProduct';
import Footer from '../../components/Footer';
import DialogCallback from '../../components/DialogCallback';
import ToggleList from '../../components/ToggleList';

new Base().call(e => {
	new Header();
	new Background();
	new ToggleList();
	
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	});
});