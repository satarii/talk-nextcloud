<!--
  - @copyright Copyright (c) 2019 Marco Ambrosini <marcoambrosini@pm.me>
  -
  - @author Marco Ambrosini <marcoambrosini@pm.me>
  -
  - @license GNU AGPL version 3 or any later version
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License
  - along with this program. If not, see <http://www.gnu.org/licenses/>.
-->

<docs>
This component displays the text inside the message component and can be used for
the main body of the message as well as a quote.
</docs>

<template>
	<div
		class="message"
		@mouseover="showActions=true"
		@mouseleave="showActions=false">
		<Quote v-if="parent" v-bind="quote" />
		<div v-if="isFirstMessage && showAuthor" class="message__author">
			<h6>{{ actorDisplayName }}</h6>
		</div>
		<div class="message__main">
			<div class="message__main__text">
				<p>{{ message }}</p>
			</div>
			<div class="message__main__right">
				<div v-if="isTemporary" class="icon-loading-small" />
				<h6 v-else>
					{{ messageTime }}
				</h6>
				<Actions v-show="showActions" class="message__main__right__actions">
					<ActionButton
						icon="icon-reply"
						:close-after-click="true"
						@click.stop="handleReply">
						Reply
					</ActionButton>
					<ActionButton
						icon="icon-delete"
						:close-after-click="true"
						@click.stop="handleDelete">
						Delete
					</ActionButton>
				</Actions>
			</div>
		</div>
	</div>
</template>

<script>
import Actions from 'nextcloud-vue/dist/Components/Actions'
import ActionButton from 'nextcloud-vue/dist/Components/ActionButton'
import Quote from './Quote/Quote'

export default {
	name: 'Message',
	components: {
		Actions,
		ActionButton,
		Quote
	},
	props: {
		/**
		 * The sender of the message.
		 */
		actorDisplayName: {
			type: String,
			required: true
		},
		/**
		 * The message or quote text.
		 */
		message: {
			type: String,
			required: true
		},
		/**
		 * The message timestamp.
		 */
		timestamp: {
			type: Number,
			default: 0
		},
		/**
		 * The message id.
		 */
		id: {
			type: Number,
			required: true
		},
		/**
		 * If true, it displays the message author on top of the message.
		 */
		showAuthor: {
			type: Boolean,
			default: true
		},
		/**
		 * Specifies if the message is temporary in order to display the spinner instead
		 * of the message time.
		 */
		isTemporary: {
			type: Boolean,
			required: true
		},
		/**
		 * Specifies if the message is the first of a group of same-author messages.
		 */
		isFirstMessage: {
			type: Boolean,
			required: true
		},
		/**
		 * The conversation token.
		 */
		token: {
			type: String,
			required: true
		},
		/**
		 * The parent message's id.
		 */
		parent: {
			type: Number
		}
	},
	data() {
		return {
			showActions: false
		}
	},
	computed: {
		messageTime() {
			return OC.Util.formatDate(this.timestamp * 1000, 'LT')
		},
		quote() {
			return this.parent && this.$store.getters.message(this.token, this.parent)
		}
	},
	methods: {
		handleReply() {
			const MESSAGE_TO_BE_REPLIED = {
				id: this.id,
				actorDisplayName: this.actorDisplayName,
				message: this.message,
				token: this.token
			}
			this.$store.dispatch('addMessageToBeReplied', Object.assign({}, MESSAGE_TO_BE_REPLIED))
		},
		handleDelete() {
			this.$store.dispatch('deleteMessage', this.message)
		}
	}
}
</script>

<style lang="scss" scoped>
@import '../../../../assets/variables';

.message {
	padding: 4px 0 4px 0;
	flex-direction: column;
	&__author {
		color: var(--color-text-maxcontrast);
	}
	&__main {
		display: flex;
		justify-content: space-between;
		min-width: 100%;
		&__text {
			flex: 1 1 400px;
			color: var(--color-text-light);
			&--quote {
			border-left: 4px solid var(--color-primary);
			padding: 4px 0 0 8px;
			}
		}
		&__right {
			justify-self: flex-start;
			justify-content:  space-between;
			position: relative;
			flex: 0 0 $message-utils-width;
			display: flex;
			color: var(--color-text-maxcontrast);
			font-size: 13px;
			padding: 0 8px 0 8px;
			&__actions {
				position: absolute;
				top: -12px;
				right: 0;
			}
		}
	}
}
</style>
