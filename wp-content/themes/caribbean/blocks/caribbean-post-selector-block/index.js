"use strict";

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _instanceof(left, right) { if (right != null && typeof Symbol !== "undefined" && right[Symbol.hasInstance]) { return !!right[Symbol.hasInstance](left); } else { return left instanceof right; } }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!_instanceof(instance, Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * BLOCK: guten-load-post
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
var __ = wp.i18n.__; // Import __() from wp.i18n

var registerBlockType = wp.blocks.registerBlockType; // Import registerBlockType() from wp.blocks

var InspectorControls = wp.blockEditor.InspectorControls;
var _wp$components = wp.components,
    SelectControl = _wp$components.SelectControl,
    Autocomplete = _wp$components.Autocomplete,
    Panel = _wp$components.Panel,
    PanelBody = _wp$components.PanelBody,
    PanelRow = _wp$components.PanelRow,
    TextControl = _wp$components.TextControl;
var Component = wp.element.Component;

var mySelectPosts =
/*#__PURE__*/
function (_Component) {
  _inherits(mySelectPosts, _Component);

  _createClass(mySelectPosts, null, [{
    key: "getInitialState",
    // Method for setting the initial state.
    value: function getInitialState(selectedPost) {
      return {
        posts: [],
        selectedPost: selectedPost,
        post: {},
        postType: 'post'
      };
    }
  }]);

  function mySelectPosts() {
    var _this;

    _classCallCheck(this, mySelectPosts);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(mySelectPosts).apply(this, arguments));

    _defineProperty(_assertThisInitialized(_this), "onChangeValue", function (value) {
      // alert(event.target.id);
      var val = document.getElementById("datalist-input").value;
      var opts = document.getElementById('autocomplete').childNodes;

      for (var i = 0; i < opts.length; i++) {
        if (opts[i].value === val) {
          // An item was selected from the list!
          _this.onChangeSelectPost(value);

          break;
        }
      }
    });

    _this.state = _this.constructor.getInitialState(_this.props.attributes.selectedPost); // Bind so we can use 'this' inside the method.

    _this.getOptions = _this.getOptions.bind(_assertThisInitialized(_this)); // Load posts.

    _this.getOptions();

    _this.onChangeSelectPost = _this.onChangeSelectPost.bind(_assertThisInitialized(_this));
    _this.onChangePostType = _this.onChangePostType.bind(_assertThisInitialized(_this));
    return _this;
  }

  _createClass(mySelectPosts, [{
    key: "getOptions",
    value: function getOptions() {
      var _this2 = this;

      return new wp.api.collections.Posts().fetch().then(function (posts) {
        if (posts && 0 !== _this2.state.selectedPost) {
          // If we have a selected Post, find that post and add it.
          var post = posts.find(function (item) {
            return item.id == _this2.state.selectedPost;
          }); // This is the same as { post: post, posts: posts }

          _this2.setState({
            post: post,
            posts: posts
          });
        } else {
          _this2.setState({
            posts: posts
          });
        }
      });
    }
  }, {
    key: "onChangeSelectPost",
    value: function onChangeSelectPost(value) {
      // Find the post
      var post = this.state.posts.find(function (item) {
        return item.id == parseInt(value);
      }); // Set the state

      this.setState({
        selectedPost: parseInt(value),
        post: post
      }); // Set the attributes

      this.props.setAttributes({
        selectedPost: parseInt(value),
        title: post.title.rendered,
        content: post.excerpt.rendered,
        link: post.link
      });
    }
  }, {
    key: "onChangePostType",
    value: function onChangePostType(value) {
      // Set the attributes
      this.props.setAttributes({
        postType: value
      });
    } // Function to handle the onChange event.

  }, {
    key: "render",
    value: function render() {
      var options = [];

      var output = __('Loading Posts');

      this.props.className += ' loading';
      console.log(this.state.posts);

      if (this.state.posts.length > 0) {
        var loading = __('Select a post to display from the right-hand side block properties sidebar.');

        output = loading.replace('%d', this.state.posts.length);
        this.state.posts.forEach(function (post) {
          options.push({
            value: post.id,
            label: post.title.rendered
          });
        });
      } else {
        output = __('No posts found. Please create some first.');
      } // Checking if we have anything in the object


      if (this.state.post.hasOwnProperty('title')) {
        output = React.createElement("div", {
          className: "post"
        }, React.createElement("a", {
          href: this.state.post.link
        }, React.createElement("h2", {
          dangerouslySetInnerHTML: {
            __html: this.state.post.title.rendered
          }
        })));
        this.props.className += ' has-post';
      } else {
        this.props.className += ' no-post';
      }

      var post_types = [{
        value: 'post',
        label: 'Post'
      }, {
        value: 'video',
        label: 'Video'
      }, {
        value: 'podcast',
        label: 'Podcast'
      }]; // Construct a unique ID for this block.

      var blockId = "autocomplete";
      return [!!this.props.isSelected && React.createElement(InspectorControls, {
        key: "inspector"
      }, React.createElement("div", null, React.createElement("label", {
        for: this.blockId
      }, __('Select a post:')), React.createElement("br", null), React.createElement(TextControl, {
        id: "datalist-input",
        list: 'autocomplete',
        onChange: this.onChangeValue,
        placeholder: "Start typing a post name..."
      }), React.createElement("datalist", {
        id: 'autocomplete'
      }, options.map(function (option, index) {
        return React.createElement("option", {
          value: option.value,
          label: option.label
        });
      }))), React.createElement(SelectControl, {
        onChange: this.onChangePostType,
        options: post_types,
        value: this.props.attributes.postType,
        label: __('Select a post type:')
      })), React.createElement("div", {
        className: this.props.className
      }, output)];
    }
  }]);

  return mySelectPosts;
}(Component);
/**
 * Register: a Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */


registerBlockType('caribbean/post-selector-block', {
  // Block name. Block names must be string that contains a namespace prefix. Example: plugin/custom-block.
  title: __('Post Selector'),
  // Block title.
  icon: 'format-aside',
  // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common',
  // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [__('post selector'), __('post'), __('video')],
  attributes: {
    title: {
      type: 'string',
      selector: 'h2'
    },
    link: {
      type: 'string',
      selector: 'a'
    },
    selectedPost: {
      type: 'number',
      default: 0
    },
    postType: {
      type: 'string',
      default: 'post'
    }
  },

  /**
   * The edit function describes the structure of your block in the context of the editor.
   * This represents what the editor will render when the block is used.
   *
   * The "edit" property must be a valid function.
   *
   * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
   *
   * @param {Object} props Props.
   * @returns {Mixed} JSX Component.
   */
  edit: mySelectPosts,

  /**
   * The save function defines the way in which the different attributes should be combined
   * into the final markup, which is then serialized by Gutenberg into post_content.
   *
   * The "save" property must be specified and must be a valid function.
   *
   * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
   *
   * @param {Object} props Props.
   * @returns {Mixed} JSX Frontend HTML.
   */
  save: function save(props) {
    return React.createElement("div", {
      className: props.className
    }, React.createElement("div", {
      className: "post"
    }, React.createElement("a", {
      href: props.attributes.link
    }, React.createElement("h2", {
      dangerouslySetInnerHTML: {
        __html: props.attributes.title
      }
    }))));
  }
});