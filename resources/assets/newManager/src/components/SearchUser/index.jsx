/**
 * SearchUser module
 * @requires react
 * @requires react#PureComponent
 * @requires prop-types
 * @requires components/InputAutoSelectDefault
 * @requires @material-ui/core/styles#withStyles
 */

import React, { PureComponent, Fragment } from 'react';
import PropTypes from 'prop-types';
import InputAutoSelectDefault from 'components/InputAutoSelectDefault';

import { findUsers } from 'server/Users';

import styles from './styles.js';
import { withStyles } from '@material-ui/core/styles';

/**
 * SearchUser block
 * @extends PureComponent
 */
class SearchUser extends PureComponent {	
	/**
	 * Props validators
	 * @type {object}
	 * @property {function} classes
	 */
	static propTypes = {
		classes: PropTypes.object.isRequired
	}

	static defaultProps = {
		defaultUser: { id: 0 },
		name: 'user_id',
		formId: '',
		onUserSelected: (value, item) => {},
		onDataLoaded: (flag) => {}
	}

	state = {
		users: [],
		value: null,
		userId: this.props.defaultUser.id
	}

	getUsersData = (users) => {
		this.setState({ users });
	}

	/**
	 * Render component
	 * @return {object} jsx object
	 */
	render() {
		let { defaultUser, formId } = this.props,
			{ users, userId } = this.state;

		return <Fragment>
			<InputAutoSelectDefault
				id={formId}
				inputedValue={this.state.value}
				data={users.data ? users.data.map((item) => {
					return {
						id: item.id,
						name: item['attributes'] ? 
							item['attributes'].fname +' '+ item['attributes'].lname +' ('+ item.email +')' :
							item.name +' ('+ item.email +')'
					}
				}) : []}
				field="name"
				defaultValue={defaultUser.name}
				label={'labelUserMultiSelect'}
				placeholder={'placeholderUserMultiSelect'}
				onInputChanged={(value, item) => {
					if (String(value).length > 0) {
						this.setState({ value });

						this.props.onDataLoaded(false);

						this.fetchUsers = findUsers(value)
							.then(this.getUsersData.bind(this))
							.then(() => item ? this.setState({ userId: item.id }, () => {
								this.props.onUserSelected(value, item);
								this.props.onDataLoaded(true);
							}) : 
							this.props.onDataLoaded(true));
					}
				}} />

			<input type="hidden" name="user_id" value={userId} />
		</Fragment>
	}
}

export default withStyles(styles)(SearchUser);

