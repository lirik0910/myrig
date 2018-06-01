import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import PaperProduct from '../../components/PaperProduct';
import FormCheckout from '../../components/FormCheckout';
import Footer from '../../components/Footer';
import DialogCallback from '../../components/DialogCallback';

new Base().call(e => {
	new Header();
	new Background();
	new PaperProduct();
	new FormCheckout();
	
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	});
});