/**
 * Base module of manager users container
 * @module ProductContainers
 * @author Ihor Bielchenko
 * @requires react
 * @requires react#Component
 * @requires redux#bindActionCreators
 * @requires react-redux#connect
 */

import App from '../App.js';
import React, { Component } from 'react';

import Grid from 'material-ui/Grid';
import { Link } from 'react-router-dom';
import Menu from '../components/Menu/Menu.jsx';
import Header from '../components/Header/Header.jsx';
import { LinearProgress } from 'material-ui/Progress';
import TopTitle from '../components/TopTitle/TopTitle.jsx';
import TabOptions from '../components/TabOptions/TabOptions.jsx';
import DialogError from '../components/DialogError/DialogError.jsx';
import PaperPageForm from '../components/PaperPageForm/PaperPageForm.jsx';
import PaperContentForm from '../components/PaperContentForm/PaperContentForm.jsx';

import PropTypes from 'prop-types';
import { withStyles } from 'material-ui/styles';

/**
 * Users base container
 * @extends Component
 */
class CreatePageContainer extends Component {

	/**
	 * Init default props
	 * @type {Object} 
	 * @inner
	 * @property {Object} classes Material defult classes collection 
	 */
	static defaultProps = {
		classes: PropTypes.object.isRequired,
	}

	state = {
		a: '',
		tab: 0,
		data: {},
		flag: true,
		completed: 100,
		resultDialog: false,
		resultDialogTitle: '',
		resultDialogMessage: ''
	}

	/**
	 * Invoked just before mounting occurs
	 * @fires componentWillMount
	 */
	componentWillMount() {
		this.getUrlProps();
	}

	/**
	 * Get props from url
	 * @param {Function} callback
	 */
	getUrlProps(callback = () => {}) {
		let { data } = this.state;
		let url = App.getLocationProps();

		if (typeof url.context_id !== 'undefined') {
			data['context_id'] = Number(url.context_id);
		}

		if (typeof url.parent_id !== 'undefined') {
			data['parent_id'] = Number(url.parent_id);
		}

		if (typeof url.link !== 'undefined') {
			data['link'] = url.link;
		}

		if (typeof url.view_id !== 'undefined') {
			data['view_id'] = url.view_id;
		}

		this.setState({ data }, () => callback());
	}

	/**
	 * Request for adding new page
	 * @param {Object} e
	 */
	pagePostRequest = e => {
		let { data } = this.state;

		this.setState({ 
			completed: 0 
		});

		App.api({
			type: 'POST',
			model: 'page',
			name: 'create',
			data,
			success: (r) => {
				r = JSON.parse(r.response);
				if (r) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Success',
						resultDialogMessage: 'The request was successful',
						a: App.name() + '/pages/'+ r.id
					}, () => {
						setTimeout(() => {
							var a = document.getElementById('page-edit');
							if (a) {
								a.click();
							}
						}, 824);
					});
				}
			},
			error: (r) => {
				r = JSON.parse(r.response);
				if (r.message) {
					this.setState({ 
						completed: 100,
						resultDialog: true,
						resultDialogTitle: 'Error',
						resultDialogMessage: r.message
					});
				}
			}
		});
	}

	transliterate(str) {
		/*var ru = ['щ', 'ш', 'ч', 'ц', 'ю', 'я', 'ё', 'ж', 'ъ', 'э', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ь'],
			en = ['shh', 'sh', 'ch', 'cz', 'yu', 'ya', 'yo', 'zh', '', 'y', 'e', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'x', '']*/

		str = str.toLowerCase();
		var cyr2latChars = new Array(
			['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
			['д', 'd'],  ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'], ['з', 'z'],
			['и', 'i'], ['й', 'y'], ['к', 'k'], ['л', 'l'],
			['м', 'm'],  ['н', 'n'], ['о', 'o'], ['п', 'p'],  ['р', 'r'],
			['с', 's'], ['т', 't'], ['у', 'u'], ['ф', 'f'],
			['х', 'h'],  ['ц', 'c'], ['ч', 'ch'],['ш', 'sh'], ['щ', 'shch'],
			['ъ', ''],  ['ы', 'y'], ['ь', ''],  ['э', 'e'], ['ю', 'yu'], ['я', 'ya'],
				
			['А', 'A'], ['Б', 'B'],  ['В', 'V'], ['Г', 'G'],
			['Д', 'D'], ['Е', 'E'], ['Ё', 'YO'],  ['Ж', 'ZH'], ['З', 'Z'],
			['И', 'I'], ['Й', 'Y'],  ['К', 'K'], ['Л', 'L'],
			['М', 'M'], ['Н', 'N'], ['О', 'O'],  ['П', 'P'],  ['Р', 'R'],
			['С', 'S'], ['Т', 'T'],  ['У', 'U'], ['Ф', 'F'],
			['Х', 'H'], ['Ц', 'C'], ['Ч', 'CH'], ['Ш', 'SH'], ['Щ', 'SHCH'],
			['Ъ', ''],  ['Ы', 'Y'],
			['Ь', ''],
			['Э', 'E'],
			['Ю', 'YU'],
			['Я', 'YA'],
			
			['a', 'a'], ['b', 'b'], ['c', 'c'], ['d', 'd'], ['e', 'e'],
			['f', 'f'], ['g', 'g'], ['h', 'h'], ['i', 'i'], ['j', 'j'],
			['k', 'k'], ['l', 'l'], ['m', 'm'], ['n', 'n'], ['o', 'o'],
			['p', 'p'], ['q', 'q'], ['r', 'r'], ['s', 's'], ['t', 't'],
			['u', 'u'], ['v', 'v'], ['w', 'w'], ['x', 'x'], ['y', 'y'],
			['z', 'z'],
				
			['A', 'A'], ['B', 'B'], ['C', 'C'], ['D', 'D'],['E', 'E'],
			['F', 'F'],['G', 'G'],['H', 'H'],['I', 'I'],['J', 'J'],['K', 'K'],
			['L', 'L'], ['M', 'M'], ['N', 'N'], ['O', 'O'],['P', 'P'],
			['Q', 'Q'],['R', 'R'],['S', 'S'],['T', 'T'],['U', 'U'],['V', 'V'],
			['W', 'W'], ['X', 'X'], ['Y', 'Y'], ['Z', 'Z'],
			
			[' ', '_'],['0', '0'],['1', '1'],['2', '2'],['3', '3'],
			['4', '4'],['5', '5'],['6', '6'],['7', '7'],['8', '8'],['9', '9'],
			['-', '-']
		);
		var newStr = new String(),
			ch;
		for (var i = 0; i < str.length; i++) {

			ch = str.charAt(i);
			var newCh = '';

			for (var j = 0; j < cyr2latChars.length; j++) {
				if (ch == cyr2latChars[j][0]) {
					newCh = cyr2latChars[j][1];

				}
			}
			newStr += newCh;

		}
		return newStr.replace(/[_]{2,}/gim, '_').replace(/\n/gim, '');
	}

	/**
	 * Render component
	 * @return {Object} jsx object
	 */
	render() {
		let { classes } = this.props;
		let { 
			a, 
			tab, 
			data, 
			flag,
			completed,
			resultDialog,
			resultDialogTitle,
			resultDialogMessage
		} = this.state;

		return <div className="create-page__container">
				{completed === 0 && 
					<LinearProgress color="secondary" variant="determinate" value={completed} />}
					
				<Header
					title={'Pages list'} />
				<Menu />

				<TopTitle
					title={'New page'}
					saveButtonDisplay={true}
					onSaveButtonClicked={() => this.pagePostRequest()} />

				<TabOptions
					defaultValue={tab}
					onTabButtonClicked={tab => this.setState({ tab })}
					data={[
						'Page',
						//'Additional fields',
					]} />

				<Grid container 
					spacing={24} 
					className={classes.root}
					style={{display: tab === 0 ? 
						'flex' : 
						'none'}}>
				
					<Grid item xs={9}>
						<PaperContentForm
							descrShow
							introShow
							onEditorAreaInputed={value => {
								data['content'] = value;
								this.setState({ data });
							}}
							onTitleFieldInputed={value => {
								this.setState({ flag: false }, () => {
									let url = App.getLocationProps()
									var link = '';
									
									if (typeof url.link !== 'undefined') {
										link += url.link +'/';
									}

									link += this.transliterate(value);

									data['title'] = value;
									data['link'] = link;

									this.setState({ data }, () => {
										this.setState({ flag: true });
									});
								});
							}}
							onDescrFieldInputed={value => {
								data['description'] = value;
								this.setState({ data });
							}}
							onIntroFieldInputed={value => {
								data['introtext'] = value;
								this.setState({ data });
							}} />
					</Grid>

					<Grid item xs={3}>
						<PaperPageForm
							flag={flag}
							linkDefaultValue={data.link}
							viewDefaultValue={data.view_id}
							contextDefaultValue={data.context_id}
							parentDefaultValue={data.parent_id ? data.parent_id : 0}
							onParentSelected={value => {
								data['parent_id'] = value;
								this.setState({ data });
							}}
							onContextSelected={value => {
								data['context_id'] = value;
								this.setState({ data });
							}}
							onViewSelected={value => {
								data['view_id'] = value;
								this.setState({ data });
							}}
							onDateSelected={value => {
								var date = value._d.toISOString().split('T')[0],
									time = value._d.toLocaleTimeString();
				
								data['created_at'] = date +' '+ time;
								this.setState({ data });
							}}
							onLinkInputed={value => {
								data['link'] = value;
								this.setState({ data });
							}} />
					</Grid>
				</Grid>

				{resultDialog === true && <DialogError 
					title={resultDialogTitle}
					defaultValue={resultDialog}
					message={resultDialogMessage}
					onDialogClosed={() => this.setState({
						resultDialog: false
					})} />}

				<Link to={a}
					id="page-edit"
					style={{display: 'none'}}></Link>
			</div>
	}
}

let styles = theme => ({
	root: {
		width: '100%',
		margin: 0,
		padding: 0,
	},
});

export default withStyles(styles)(CreatePageContainer);