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
	constructor(props) {
		super(props);

		this.fetchUsers = findUsers()
			.then(this.getUsersData.bind(this));
	}
	
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
		onUserSelected: (value, item) => {}
	}

	state = {
		users: [],
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
		let { defaultUser } = this.props,
			{ users, userId } = this.state;

		return <Fragment>
			<InputAutoSelectDefault
				data={users.data}
				field="name"
				defaultValue={defaultUser.name}
				label={'labelUserMultiSelect'}
				placeholder={'placeholderUserMultiSelect'}
				onInputChanged={(value, item) => item && this.setState({ userId: item.id }, () => 
					this.props.onUserSelected(value, item))} />

			<input type="hidden" name="user_id" value={userId} />
		</Fragment>
	}
}

export default withStyles(styles)(SearchUser);

