import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import PaperProduct from '../../components/PaperProduct';
import ButtonSendToCart from '../../components/ButtonSendToCart';
import Footer from '../../components/Footer';
import DialogCallback from '../../components/DialogCallback';
import InputProductsCount from '../../components/InputProductsCount';

new Base().call(e => {
	new Header();
	new Background();
	new PaperProduct();
	new InputProductsCount();
	new ButtonSendToCart();
	
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	});
});