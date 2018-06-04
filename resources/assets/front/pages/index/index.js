import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import SliderIndex from '../../components/SliderIndex';
import Footer from '../../components/Footer';
import DialogCallback from '../../components/DialogCallback';

new Base().call(e => {
	new Header();
	new Background();
	new SliderIndex();
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	});
});