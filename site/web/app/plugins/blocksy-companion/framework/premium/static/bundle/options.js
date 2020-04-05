/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./framework/premium/static/js/options.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./framework/extensions/instagram/static/js/helpers.js":
/*!*************************************************************!*\
  !*** ./framework/extensions/instagram/static/js/helpers.js ***!
  \*************************************************************/
/*! exports provided: onDocumentLoaded */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"onDocumentLoaded\", function() { return onDocumentLoaded; });\nvar onDocumentLoaded = function onDocumentLoaded(cb) {\n  if (/comp|inter|loaded/.test(document.readyState)) {\n    cb();\n  } else {\n    document.addEventListener('DOMContentLoaded', cb, false);\n  }\n};\n\n//# sourceURL=webpack:///./framework/extensions/instagram/static/js/helpers.js?");

/***/ }),

/***/ "./framework/premium/static/js/code-editor.js":
/*!****************************************************!*\
  !*** ./framework/premium/static/js/code-editor.js ***!
  \****************************************************/
/*! exports provided: mountCodeEditor */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"mountCodeEditor\", function() { return mountCodeEditor; });\nvar mountCodeEditor = function mountCodeEditor() {\n  var maybeCodeEditor = document.querySelector('#blocksy-inline-code');\n  var editorTrigger = document.querySelector('.blocksy-code-editor-trigger');\n  var instance = null;\n\n  if (maybeCodeEditor) {\n    instance = wp.codeEditor.initialize('blocksy-inline-code', blocksy_premium_admin.editor_settings);\n    instance.codemirror.on('change', function (editor) {\n      ctEvents.trigger('ct:options:trigger-change', {\n        id: 'inline_code',\n        value: editor.getValue(),\n        input: document.querySelector('[name=\"blocksy_post_meta_options[ct_options]\"]')\n      });\n    });\n  }\n\n  if (editorTrigger) {\n    editorTrigger.addEventListener('click', function (e) {\n      e.preventDefault();\n      var isEnabled = document.body.classList.contains('blocksy-inline-code-editor');\n      document.body.classList.remove('blocksy-inline-code-editor');\n\n      if (!isEnabled) {\n        document.body.classList.add('blocksy-inline-code-editor');\n      }\n\n      ctEvents.trigger('ct:options:trigger-change', {\n        id: 'has_inline_code_editor',\n        value: isEnabled ? 'no' : 'yes',\n        input: document.querySelector('[name=\"blocksy_post_meta_options[ct_options]\"]')\n      });\n      instance.codemirror.refresh();\n      setTimeout(function () {\n        tinymce.activeEditor.setContent(tinymce.activeEditor.getContent());\n        setTimeout(function () {\n          tinymce.activeEditor.setContent(tinymce.activeEditor.getContent());\n        });\n      });\n    });\n  }\n};\n\n//# sourceURL=webpack:///./framework/premium/static/js/code-editor.js?");

/***/ }),

/***/ "./framework/premium/static/js/header/BuilderTemplates.js":
/*!****************************************************************!*\
  !*** ./framework/premium/static/js/header/BuilderTemplates.js ***!
  \****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ \"./node_modules/classnames/index.js\");\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! blocksy-options */ \"blocksy-options\");\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(blocksy_options__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ct-i18n */ \"ct-i18n\");\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(ct_i18n__WEBPACK_IMPORTED_MODULE_3__);\n\n\n\n\n\nvar BuilderTemplates = function BuilderTemplates() {\n  var _useContext = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useContext\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"PlacementsDragDropContext\"]),\n      builderValueCollection = _useContext.builderValueCollection,\n      builderValue = _useContext.builderValue,\n      builderValueDispatch = _useContext.builderValueDispatch;\n\n  var secondaryItems = ct_customizer_localizations.header_builder_data.secondary_items.header;\n  var allItems = ct_customizer_localizations.header_builder_data.header;\n  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"Select\"], {\n    onChange: function onChange(id) {\n      return builderValueDispatch({\n        type: 'PICK_BUILDER_SECTION',\n        payload: {\n          id: id\n        }\n      });\n    },\n    option: {\n      placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_3__[\"__\"])('Picker header', 'blocksy'),\n      choices: builderValueCollection.sections.map(function (_ref) {\n        var name = _ref.name,\n            id = _ref.id;\n        return {\n          key: id,\n          value: name || {\n            'type-1': Object(ct_i18n__WEBPACK_IMPORTED_MODULE_3__[\"__\"])('Default', 'blocksy'),\n            'type-2': Object(ct_i18n__WEBPACK_IMPORTED_MODULE_3__[\"__\"])('Secondary', 'blocksy'),\n            'type-3': Object(ct_i18n__WEBPACK_IMPORTED_MODULE_3__[\"__\"])('Centered', 'blocksy')\n          }[id] || id\n        };\n      })\n    },\n    renderItemFor: function renderItemFor(item) {\n      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"Fragment\"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"span\", null, item.value), item.key !== builderValue.id && item.key.indexOf('ct-custom') > -1 && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"span\", {\n        onClick: function onClick(e) {\n          e.preventDefault();\n          e.stopPropagation();\n          builderValueDispatch({\n            type: 'REMOVE_BUILDER_SECTION',\n            payload: {\n              id: item.key\n            }\n          });\n        }\n      }, \"remove\"));\n    },\n    value: builderValue.id\n  });\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (BuilderTemplates);\n\n//# sourceURL=webpack:///./framework/premium/static/js/header/BuilderTemplates.js?");

/***/ }),

/***/ "./framework/premium/static/js/header/CreateHeader.js":
/*!************************************************************!*\
  !*** ./framework/premium/static/js/header/CreateHeader.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! blocksy-options */ \"blocksy-options\");\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(blocksy_options__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ct-i18n */ \"ct-i18n\");\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(ct_i18n__WEBPACK_IMPORTED_MODULE_2__);\nfunction ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }\n\nfunction _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }\n\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\nfunction _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance\"); }\n\nfunction _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === \"[object Arguments]\")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\n\n\n\n\nvar CreateHeader = function CreateHeader() {\n  var _useState = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(false),\n      _useState2 = _slicedToArray(_useState, 2),\n      isCreating = _useState2[0],\n      setIsCreating = _useState2[1];\n\n  var _useState3 = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])({\n    name: '',\n    copy: null\n  }),\n      _useState4 = _slicedToArray(_useState3, 2),\n      _useState4$ = _useState4[0],\n      name = _useState4$.name,\n      copy = _useState4$.copy,\n      setHeaderData = _useState4[1];\n\n  var _useContext = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useContext\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"PlacementsDragDropContext\"]),\n      builderValueCollection = _useContext.builderValueCollection,\n      builderValueDispatch = _useContext.builderValueDispatch;\n\n  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"Fragment\"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"button\", {\n    onClick: function onClick(e) {\n      e.preventDefault();\n      /*\n      builderValueDispatch({\n      \ttype: 'CREATE_NEW_SECTION',\n      \tpayload: {}\n      })\n                     */\n\n      setIsCreating(true);\n    }\n  }, \"create header\"), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"Overlay\"], {\n    items: isCreating,\n    className: \"ct-admin-modal ct-create-header-modal\",\n    onDismiss: function onDismiss() {\n      setIsCreating(false);\n      setHeaderData({\n        name: '',\n        copy: null\n      });\n    },\n    render: function render() {\n      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n        className: \"ct-header-conditions\"\n      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"h1\", null, sprintf(Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Create Header', 'blc'))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"label\", null, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Copy data from', 'blc'), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"Switch\"], {\n        value: copy ? 'yes' : 'no',\n        onChange: function onChange() {\n          setHeaderData(function (data) {\n            return _objectSpread({}, data, {\n              copy: data.copy ? null : builderValueCollection.current_section\n            });\n          });\n        }\n      })), copy && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"Select\"], {\n        onChange: function onChange(copy) {\n          return setHeaderData(function (data) {\n            return _objectSpread({}, data, {\n              copy: copy\n            });\n          });\n        },\n        option: {\n          placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Picker header', 'blocksy'),\n          choices: builderValueCollection.sections.map(function (_ref) {\n            var name = _ref.name,\n                id = _ref.id;\n            return {\n              key: id,\n              value: name || {\n                'type-1': Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Default', 'blocksy'),\n                'type-2': Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Secondary', 'blocksy'),\n                'type-3': Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Centered', 'blocksy')\n              }[id] || id\n            };\n          })\n        },\n        value: copy\n      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"input\", {\n        type: \"text\",\n        value: name,\n        onChange: function onChange(_ref2) {\n          var value = _ref2.target.value;\n          setHeaderData(function (data) {\n            return _objectSpread({}, data, {\n              name: value\n            });\n          });\n        },\n        placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Edit Name', 'blc')\n      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n        className: \"ct-create-header-actions\"\n      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"button\", {\n        className: \"button-primary\",\n        onClick: function onClick() {\n          builderValueDispatch({\n            type: 'CREATE_NEW_SECTION',\n            payload: {\n              name: name,\n              copy: copy\n            }\n          });\n          setIsCreating(false);\n          setTimeout(function () {\n            setHeaderData({\n              name: '',\n              copy: null\n            });\n          }, 1000);\n        },\n        disabled: !name\n      }, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Create New Header', 'blc'))));\n    }\n  }));\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (CreateHeader);\n\n//# sourceURL=webpack:///./framework/premium/static/js/header/CreateHeader.js?");

/***/ }),

/***/ "./framework/premium/static/js/header/EditConditions.js":
/*!**************************************************************!*\
  !*** ./framework/premium/static/js/header/EditConditions.js ***!
  \**************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! blocksy-options */ \"blocksy-options\");\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(blocksy_options__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ct-i18n */ \"ct-i18n\");\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(ct_i18n__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var react_fetch_hook__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react-fetch-hook */ \"./node_modules/react-fetch-hook/index.js\");\n/* harmony import */ var react_fetch_hook__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_fetch_hook__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var react_use_trigger__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react-use-trigger */ \"./node_modules/react-use-trigger/index.js\");\n/* harmony import */ var react_use_trigger__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react_use_trigger__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var react_use_trigger_useTrigger__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react-use-trigger/useTrigger */ \"./node_modules/react-use-trigger/useTrigger.js\");\n/* harmony import */ var react_use_trigger_useTrigger__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_use_trigger_useTrigger__WEBPACK_IMPORTED_MODULE_5__);\nfunction _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance\"); }\n\nfunction _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === \"[object Arguments]\") return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }\n\nfunction asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }\n\nfunction _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"next\", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"throw\", err); } _next(undefined); }); }; }\n\nfunction _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance\"); }\n\nfunction _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === \"[object Arguments]\")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\n\n\n\n\n\n\nvar requestTrigger = react_use_trigger__WEBPACK_IMPORTED_MODULE_4___default()();\n\nvar EditConditions = function EditConditions() {\n  var _useState = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(false),\n      _useState2 = _slicedToArray(_useState, 2),\n      isEditing = _useState2[0],\n      setIsEditing = _useState2[1];\n\n  var _useState3 = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(null),\n      _useState4 = _slicedToArray(_useState3, 2),\n      localConditions = _useState4[0],\n      setConditions = _useState4[1];\n\n  var _useContext = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useContext\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"PlacementsDragDropContext\"]),\n      builderValueCollection = _useContext.builderValueCollection,\n      builderValueDispatch = _useContext.builderValueDispatch;\n\n  var requestTriggerValue = react_use_trigger_useTrigger__WEBPACK_IMPORTED_MODULE_5___default()(requestTrigger);\n\n  var saveSettings = function saveSettings() {\n    wp.ajax.send({\n      url: \"\".concat(wp.ajax.settings.url, \"?action=blocksy_header_update_all_conditions\"),\n      contentType: 'application/json',\n      data: JSON.stringify(localConditions)\n    }).then(function () {\n      requestTrigger();\n      setIsEditing(false);\n    });\n  };\n\n  var _useFetch = react_fetch_hook__WEBPACK_IMPORTED_MODULE_3___default()(\"\".concat(blocksy_premium_admin.ajax_url, \"?action=blocksy_header_get_all_conditions\"), {\n    method: 'POST',\n    formatter: function () {\n      var _formatter = _asyncToGenerator(\n      /*#__PURE__*/\n      regeneratorRuntime.mark(function _callee(r) {\n        var _ref, success, data;\n\n        return regeneratorRuntime.wrap(function _callee$(_context) {\n          while (1) {\n            switch (_context.prev = _context.next) {\n              case 0:\n                _context.next = 2;\n                return r.json();\n\n              case 2:\n                _ref = _context.sent;\n                success = _ref.success;\n                data = _ref.data;\n\n                if (!(!success || !data.conditions)) {\n                  _context.next = 7;\n                  break;\n                }\n\n                throw new Error();\n\n              case 7:\n                return _context.abrupt(\"return\", data.conditions);\n\n              case 8:\n              case \"end\":\n                return _context.stop();\n            }\n          }\n        }, _callee);\n      }));\n\n      function formatter(_x) {\n        return _formatter.apply(this, arguments);\n      }\n\n      return formatter;\n    }(),\n    depends: [requestTriggerValue]\n  }),\n      conditions = _useFetch.data,\n      isLoading = _useFetch.isLoading,\n      error = _useFetch.error;\n\n  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"Fragment\"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"span\", {\n    className: \"ct-conditions-trigger\",\n    onClick: function onClick() {\n      if (isLoading) {\n        return;\n      }\n\n      setIsEditing(true);\n    }\n  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"i\", {\n    className: \"ct-tooltip-top\"\n  }, sprintf(Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Conditions', 'blc')))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"Overlay\"], {\n    items: isEditing,\n    className: \"ct-admin-modal ct-conditions-modal\",\n    onDismiss: function onDismiss() {\n      setIsEditing(false);\n      setConditions(null);\n    },\n    render: function render() {\n      return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n        className: \"ct-header-conditions\"\n      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"h1\", null, sprintf(Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Display Conditions', 'blc'))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"p\", null, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Add one or more conditions in order to display your header.', 'blc')), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_1__[\"OptionsPanel\"], {\n        onChange: function onChange(optionId, cond) {\n          setConditions(function (localConditions) {\n            return [].concat(_toConsumableArray((localConditions || conditions).filter(function (_ref2) {\n              var id = _ref2.id;\n              return id !== builderValueCollection.current_section;\n            })), [{\n              id: builderValueCollection.current_section,\n              conditions: cond\n            }]);\n          });\n        },\n        options: {\n          conditions: {\n            type: 'blocksy-display-condition',\n            value: [],\n            label: false\n          }\n        },\n        value: {\n          conditions: ((localConditions || conditions).find(function (_ref3) {\n            var id = _ref3.id;\n            return id === builderValueCollection.current_section;\n          }) || {\n            conditions: []\n          }).conditions\n        },\n        hasRevertButton: false\n      }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n        className: \"ct-conditions-actions\"\n      }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"button\", {\n        className: \"button-primary\",\n        disabled: !localConditions,\n        onClick: function onClick() {\n          return saveSettings();\n        }\n      }, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Save Settings', 'blc'))));\n    }\n  }));\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (EditConditions);\n\n//# sourceURL=webpack:///./framework/premium/static/js/header/EditConditions.js?");

/***/ }),

/***/ "./framework/premium/static/js/header/PreviewedHeader.js":
/*!***************************************************************!*\
  !*** ./framework/premium/static/js/header/PreviewedHeader.js ***!
  \***************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! blocksy-options */ \"blocksy-options\");\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(blocksy_options__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ct-i18n */ \"ct-i18n\");\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(ct_i18n__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _BuilderTemplates__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./BuilderTemplates */ \"./framework/premium/static/js/header/BuilderTemplates.js\");\n/* harmony import */ var _EditConditions__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./EditConditions */ \"./framework/premium/static/js/header/EditConditions.js\");\n/* harmony import */ var _CreateHeader__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./CreateHeader */ \"./framework/premium/static/js/header/CreateHeader.js\");\n\n\n\n\n\n\n\nvar PreviewedHeader = function PreviewedHeader() {\n  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"Fragment\"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"h3\", {\n    className: \"ct-title\"\n  }, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Previewed Header', 'blc')), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n    className: \"ct-instance-selector\"\n  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_BuilderTemplates__WEBPACK_IMPORTED_MODULE_3__[\"default\"], null), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_EditConditions__WEBPACK_IMPORTED_MODULE_4__[\"default\"], null), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_CreateHeader__WEBPACK_IMPORTED_MODULE_5__[\"default\"], null)), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n    className: \"ct-option-description\"\n  }, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_2__[\"__\"])('Preview Headers', 'blc')));\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (PreviewedHeader);\n\n//# sourceURL=webpack:///./framework/premium/static/js/header/PreviewedHeader.js?");

/***/ }),

/***/ "./framework/premium/static/js/options.js":
/*!************************************************!*\
  !*** ./framework/premium/static/js/options.js ***!
  \************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _options_DisplayCondition__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./options/DisplayCondition */ \"./framework/premium/static/js/options/DisplayCondition.js\");\n/* harmony import */ var _options_HooksSelect__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./options/HooksSelect */ \"./framework/premium/static/js/options/HooksSelect.js\");\n/* harmony import */ var _extensions_instagram_static_js_helpers__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../../extensions/instagram/static/js/helpers */ \"./framework/extensions/instagram/static/js/helpers.js\");\n/* harmony import */ var _code_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./code-editor */ \"./framework/premium/static/js/code-editor.js\");\n/* harmony import */ var ct_events__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ct-events */ \"ct-events\");\n/* harmony import */ var ct_events__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(ct_events__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var _header_EditConditions__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./header/EditConditions */ \"./framework/premium/static/js/header/EditConditions.js\");\n/* harmony import */ var _header_CreateHeader__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./header/CreateHeader */ \"./framework/premium/static/js/header/CreateHeader.js\");\n/* harmony import */ var _header_PreviewedHeader__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./header/PreviewedHeader */ \"./framework/premium/static/js/header/PreviewedHeader.js\");\n\n\n\n\n\n\n\n\n\n\nObject(_extensions_instagram_static_js_helpers__WEBPACK_IMPORTED_MODULE_4__[\"onDocumentLoaded\"])(function () {\n  Object(_code_editor__WEBPACK_IMPORTED_MODULE_5__[\"mountCodeEditor\"])();\n});\nct_events__WEBPACK_IMPORTED_MODULE_6___default.a.on('blocksy:options:before-option', function (args) {\n  if (!args.option) {\n    return;\n  }\n\n  if (args.option.type !== 'ct-header-builder') {\n    return;\n  }\n\n  args.content = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__[\"Fill\"], {\n    name: \"BuilderTemplates\"\n  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(_header_PreviewedHeader__WEBPACK_IMPORTED_MODULE_9__[\"default\"], null));\n});\nct_events__WEBPACK_IMPORTED_MODULE_6___default.a.on('blocksy:options:register', function (opts) {\n  opts['blocksy-display-condition'] = _options_DisplayCondition__WEBPACK_IMPORTED_MODULE_2__[\"default\"];\n  opts['blocksy-hooks-select'] = _options_HooksSelect__WEBPACK_IMPORTED_MODULE_3__[\"default\"];\n});\n\n//# sourceURL=webpack:///./framework/premium/static/js/options.js?");

/***/ }),

/***/ "./framework/premium/static/js/options/DisplayCondition.js":
/*!*****************************************************************!*\
  !*** ./framework/premium/static/js/options/DisplayCondition.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ct-i18n */ \"ct-i18n\");\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(ct_i18n__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! blocksy-options */ \"blocksy-options\");\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(blocksy_options__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ \"./node_modules/classnames/index.js\");\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);\nfunction _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance\"); }\n\nfunction _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === \"[object Arguments]\")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\nfunction _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }\n\nfunction _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }\n\nfunction ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }\n\nfunction _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }\n\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\nfunction _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance\"); }\n\nfunction _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === \"[object Arguments]\") return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }\n\n\n\n\n\nvar allPostsCache = [];\nvar allTaxonomiesCache = [];\n\nvar DisplayCondition = function DisplayCondition(_ref) {\n  var value = _ref.value,\n      _onChange = _ref.onChange;\n  var allRules = blocksy_premium_admin.all_condition_rules.reduce(function (current, _ref2) {\n    var rules = _ref2.rules,\n        title = _ref2.title;\n    return [].concat(_toConsumableArray(current), _toConsumableArray(rules.map(function (r) {\n      return _objectSpread({}, r, {\n        group: title\n      });\n    })));\n  }, []).reduce(function (current, _ref3) {\n    var title = _ref3.title,\n        id = _ref3.id,\n        rest = _objectWithoutProperties(_ref3, [\"title\", \"id\"]);\n\n    return [].concat(_toConsumableArray(current), [_objectSpread({\n      key: id,\n      value: title\n    }, rest)]);\n  }, []);\n\n  var _useState = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(allPostsCache),\n      _useState2 = _slicedToArray(_useState, 2),\n      allPosts = _useState2[0],\n      setAllPosts = _useState2[1];\n\n  var _useState3 = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(allTaxonomiesCache),\n      _useState4 = _slicedToArray(_useState3, 2),\n      allTaxonomies = _useState4[0],\n      setAllTaxonomies = _useState4[1];\n\n  var hasAdditions = function hasAdditions(condition) {\n    return condition.rule === 'post_ids' || condition.rule === 'taxonomy_ids';\n  };\n\n  Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"useEffect\"])(function () {\n    Promise.all(['posts', 'pages'].map(function (type) {\n      return fetch(\"\".concat(blocksy_premium_admin.rest_url, \"wp/v2/\").concat(type).concat(blocksy_premium_admin.rest_url.indexOf('?') > -1 ? '&' : '?', \"_embed&per_page=100\")).then(function (r) {\n        return r.json();\n      });\n    })).then(function (results) {\n      var all = results.reduce(function (r, current) {\n        return [].concat(_toConsumableArray(r), _toConsumableArray(current));\n      }, []);\n      setAllPosts(all);\n      allPostsCache = all;\n    });\n    Promise.all(['categories', 'tags'].map(function (type) {\n      return fetch(\"\".concat(blocksy_premium_admin.rest_url, \"wp/v2/\").concat(type).concat(blocksy_premium_admin.rest_url.indexOf('?') > -1 ? '&' : '?', \"_embed&per_page=100\")).then(function (r) {\n        return r.json();\n      });\n    })).then(function (results) {\n      var all = results.reduce(function (r, current) {\n        return [].concat(_toConsumableArray(r), _toConsumableArray(current));\n      }, []);\n      setAllTaxonomies(all);\n      allTaxonomiesCache = all;\n    });\n  }, []);\n  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n    className: \"ct-display-conditions\"\n  }, value.map(function (condition, index) {\n    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"div\", {\n      className: classnames__WEBPACK_IMPORTED_MODULE_3___default()('ct-condition-group', {\n        'ct-cols-3': hasAdditions(condition),\n        'ct-cols-2': !hasAdditions(condition)\n      }),\n      key: index\n    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"Select\"], {\n      option: {\n        inputClassName: 'ct-condition-type',\n        selectInputStart: function selectInputStart() {\n          return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"span\", {\n            className: \"ct-\".concat(condition.type)\n          });\n        },\n        placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Select variation', 'blc'),\n        choices: {\n          include: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Include', 'blc'),\n          exclude: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Exclude', 'blc')\n        }\n      },\n      value: condition.type,\n      onChange: function onChange(type) {\n        _onChange(value.map(function (r, i) {\n          return _objectSpread({}, i === index ? _objectSpread({}, condition, {\n            type: type\n          }) : r);\n        }));\n      }\n    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"Select\"], {\n      option: {\n        placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Select rule', 'blc'),\n        choices: allRules,\n        search: true\n      },\n      value: condition.rule,\n      onChange: function onChange(rule) {\n        _onChange(value.map(function (r, i) {\n          return _objectSpread({}, i === index ? _objectSpread({}, condition, {\n            rule: rule\n          }) : r);\n        }));\n      }\n    }), condition.rule === 'post_ids' && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"Select\"], {\n      option: {\n        defaultToFirstItem: false,\n        placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Select post', 'blc'),\n        choices: allPosts.map(function (post) {\n          return {\n            key: post.id,\n            value: post.title.rendered\n          };\n        }),\n        search: true\n      },\n      value: condition.payload.post_id || '',\n      onChange: function onChange(post_id) {\n        _onChange(value.map(function (r, i) {\n          return _objectSpread({}, i === index ? _objectSpread({}, condition, {\n            payload: _objectSpread({}, condition.payload, {\n              post_id: post_id\n            })\n          }) : r);\n        }));\n      }\n    }), condition.rule === 'taxonomy_ids' && Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"Select\"], {\n      option: {\n        defaultToFirstItem: false,\n        placeholder: Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Select taxonomy', 'blc'),\n        choices: allTaxonomies.map(function (taxonomy) {\n          return {\n            key: taxonomy.id,\n            value: taxonomy.name\n          };\n        }),\n        search: true\n      },\n      value: condition.payload.taxonomy_id || '',\n      onChange: function onChange(taxonomy_id) {\n        _onChange(value.map(function (r, i) {\n          return _objectSpread({}, i === index ? _objectSpread({}, condition, {\n            payload: _objectSpread({}, condition.payload, {\n              taxonomy_id: taxonomy_id\n            })\n          }) : r);\n        }));\n      }\n    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"button\", {\n      type: \"button\",\n      onClick: function onClick(e) {\n        e.preventDefault();\n\n        var newValue = _toConsumableArray(value);\n\n        newValue.splice(index, 1);\n\n        _onChange(newValue);\n      }\n    }, \"\\xD7\"));\n  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(\"button\", {\n    type: \"button\",\n    className: \"button\",\n    onClick: function onClick(e) {\n      e.preventDefault();\n\n      _onChange([].concat(_toConsumableArray(value), [{\n        type: 'include',\n        rule: 'everywhere',\n        payload: {}\n      }]));\n    }\n  }, Object(ct_i18n__WEBPACK_IMPORTED_MODULE_1__[\"__\"])('Add New Condition', 'blc')));\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (DisplayCondition);\n\n//# sourceURL=webpack:///./framework/premium/static/js/options/DisplayCondition.js?");

/***/ }),

/***/ "./framework/premium/static/js/options/HooksSelect.js":
/*!************************************************************!*\
  !*** ./framework/premium/static/js/options/HooksSelect.js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ \"@wordpress/element\");\n/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ct-i18n */ \"ct-i18n\");\n/* harmony import */ var ct_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(ct_i18n__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! blocksy-options */ \"blocksy-options\");\n/* harmony import */ var blocksy_options__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(blocksy_options__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ \"./node_modules/classnames/index.js\");\n/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);\nfunction _extends() { _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; }; return _extends.apply(this, arguments); }\n\nfunction _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }\n\nfunction _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }\n\n\n\n\n\n\nvar HooksSelect = function HooksSelect(_ref) {\n  var _onChange = _ref.onChange,\n      onChangeFor = _ref.onChangeFor,\n      props = _objectWithoutProperties(_ref, [\"onChange\", \"onChangeFor\"]);\n\n  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__[\"createElement\"])(blocksy_options__WEBPACK_IMPORTED_MODULE_2__[\"Select\"], _extends({\n    onChangeFor: onChangeFor,\n    onChange: function onChange(value) {\n      _onChange(value);\n\n      onChangeFor('priority', blocksy_premium_admin.all_hooks.find(function (_ref2) {\n        var hook = _ref2.hook;\n        return hook === value;\n      }).priority || 10);\n    }\n  }, props));\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (HooksSelect);\n\n//# sourceURL=webpack:///./framework/premium/static/js/options/HooksSelect.js?");

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!\n  Copyright (c) 2017 Jed Watson.\n  Licensed under the MIT License (MIT), see\n  http://jedwatson.github.io/classnames\n*/\n/* global define */\n\n(function () {\n\t'use strict';\n\n\tvar hasOwn = {}.hasOwnProperty;\n\n\tfunction classNames () {\n\t\tvar classes = [];\n\n\t\tfor (var i = 0; i < arguments.length; i++) {\n\t\t\tvar arg = arguments[i];\n\t\t\tif (!arg) continue;\n\n\t\t\tvar argType = typeof arg;\n\n\t\t\tif (argType === 'string' || argType === 'number') {\n\t\t\t\tclasses.push(arg);\n\t\t\t} else if (Array.isArray(arg) && arg.length) {\n\t\t\t\tvar inner = classNames.apply(null, arg);\n\t\t\t\tif (inner) {\n\t\t\t\t\tclasses.push(inner);\n\t\t\t\t}\n\t\t\t} else if (argType === 'object') {\n\t\t\t\tfor (var key in arg) {\n\t\t\t\t\tif (hasOwn.call(arg, key) && arg[key]) {\n\t\t\t\t\t\tclasses.push(key);\n\t\t\t\t\t}\n\t\t\t\t}\n\t\t\t}\n\t\t}\n\n\t\treturn classes.join(' ');\n\t}\n\n\tif ( true && module.exports) {\n\t\tclassNames.default = classNames;\n\t\tmodule.exports = classNames;\n\t} else if (true) {\n\t\t// register as 'classnames', consistent with npm package name\n\t\t!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {\n\t\t\treturn classNames;\n\t\t}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),\n\t\t\t\t__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));\n\t} else {}\n}());\n\n\n//# sourceURL=webpack:///./node_modules/classnames/index.js?");

/***/ }),

/***/ "./node_modules/nanoid/index.browser.js":
/*!**********************************************!*\
  !*** ./node_modules/nanoid/index.browser.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// This file replaces `index.js` in bundlers like webpack or Rollup,\n// according to `browser` config in `package.json`.\n\nif (true) {\n  // All bundlers will remove this block in production bundle\n  if (typeof navigator !== 'undefined' && navigator.product === 'ReactNative') {\n    throw new Error(\n      'React Native does not have a built-in secure random generator. ' +\n      'If you don’t need unpredictable IDs, you can use `nanoid/non-secure`. ' +\n      'For secure ID install `expo-random` locally and use `nanoid/async`.'\n    )\n  }\n  if (typeof self === 'undefined' || (!self.crypto && !self.msCrypto)) {\n    throw new Error(\n      'Your browser does not have secure random generator. ' +\n      'If you don’t need unpredictable IDs, you can use nanoid/non-secure.'\n    )\n  }\n}\n\nvar crypto = self.crypto || self.msCrypto\n\n// This alphabet uses a-z A-Z 0-9 _- symbols.\n// Symbols are generated for smaller size.\n// -_zyxwvutsrqponmlkjihgfedcba9876543210ZYXWVUTSRQPONMLKJIHGFEDCBA\nvar url = '-_'\n// Loop from 36 to 0 (from z to a and 9 to 0 in Base36).\nvar i = 36\nwhile (i--) {\n  // 36 is radix. Number.prototype.toString(36) returns number\n  // in Base36 representation. Base36 is like hex, but it uses 0–9 and a-z.\n  url += i.toString(36)\n}\n// Loop from 36 to 10 (from Z to A in Base36).\ni = 36\nwhile (i-- - 10) {\n  url += i.toString(36).toUpperCase()\n}\n\nmodule.exports = function (size) {\n  var id = ''\n  var bytes = crypto.getRandomValues(new Uint8Array(size || 21))\n  i = size || 21\n\n  // Compact alternative for `for (var i = 0; i < size; i++)`\n  while (i--) {\n    // We can’t use bytes bigger than the alphabet. 63 is 00111111 bitmask.\n    // This mask reduces random byte 0-255 to 0-63 values.\n    // There is no need in `|| ''` and `* 1.6` hacks in here,\n    // because bitmask trim bytes exact to alphabet size.\n    id += url[bytes[i] & 63]\n  }\n  return id\n}\n\n\n//# sourceURL=webpack:///./node_modules/nanoid/index.browser.js?");

/***/ }),

/***/ "./node_modules/react-fetch-hook/index.js":
/*!************************************************!*\
  !*** ./node_modules/react-fetch-hook/index.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var usePromise = __webpack_require__(/*! ./usePromise */ \"./node_modules/react-fetch-hook/usePromise.js\")\n\nfunction UseFetchError (status, statusText, message, fileName, lineNumber) {\n  var instance = new Error(message, fileName, lineNumber)\n  instance.name = 'UseFetchError'\n  instance.status = status\n  instance.statusText = statusText\n  Object.setPrototypeOf(instance, Object.getPrototypeOf(this))\n  if (Error.captureStackTrace) {\n    Error.captureStackTrace(instance, UseFetchError)\n  }\n  return instance\n}\n\nUseFetchError.prototype = Object.create(Error.prototype, {\n  constructor: {\n    value: Error,\n    enumerable: false,\n    writable: true,\n    configurable: true\n  }\n})\n\nObject.setPrototypeOf(UseFetchError, Error)\n\nfunction useFetch (\n  path,\n  options,\n  specialOptions\n) {\n  var blocked = ((specialOptions && specialOptions.depends) ||\n      (options && options.depends) || [])\n    .reduce(function (acc, dep) { return acc || !dep }, false)\n  return usePromise(!blocked && function (p, o, s) {\n    return fetch(p, o)\n      .then((s && s.formatter) || (o && o.formatter) || function (response) {\n        if (!response.ok) {\n          throw new UseFetchError(\n            response.status,\n            response.statusText,\n            'Fetch error'\n          )\n        }\n        return response.json()\n      })\n  },\n  path, options || {}, specialOptions || {})\n}\n\nmodule.exports = useFetch\n\n\n//# sourceURL=webpack:///./node_modules/react-fetch-hook/index.js?");

/***/ }),

/***/ "./node_modules/react-fetch-hook/usePromise.js":
/*!*****************************************************!*\
  !*** ./node_modules/react-fetch-hook/usePromise.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var React = __webpack_require__(/*! react */ \"react\")\n\nvar flattenInput = __webpack_require__(/*! ./utils/flattenInput */ \"./node_modules/react-fetch-hook/utils/flattenInput.js\")\n\nfunction usePromise (\n  callFunction\n) {\n  var inputs = Array.prototype.slice.call(arguments, [1])\n  var state = React.useState({\n    isLoading: !!callFunction\n  })\n\n  React.useEffect(function () {\n    if (!callFunction) {\n      return\n    }\n    !state[0].isLoading && state[1]({ data: state[0].data, isLoading: true })\n    callFunction.apply(null, inputs)\n      .then(function (data) {\n        state[1]({\n          data: data,\n          isLoading: false\n        })\n      })\n      .catch(function (error) {\n        state[1]({\n          error: error,\n          isLoading: false\n        })\n      })\n  }, flattenInput(inputs))\n\n  return state[0]\n}\n\nmodule.exports = usePromise\n\n\n//# sourceURL=webpack:///./node_modules/react-fetch-hook/usePromise.js?");

/***/ }),

/***/ "./node_modules/react-fetch-hook/utils/flattenInput.js":
/*!*************************************************************!*\
  !*** ./node_modules/react-fetch-hook/utils/flattenInput.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function flattenInput () {\n  var res = []\n  for (var i = 0; i < arguments.length; i++) {\n    var input = arguments[i]\n    if (input instanceof Array) {\n      for (var j = 0; j < input.length; j++) {\n        res = res.concat(flattenInput(input[j]))\n      }\n    } else if (typeof URL !== 'undefined' && input instanceof URL) {\n      res = res.concat(input.toJSON())\n    } else if (input instanceof Object) {\n      var keys = Object.keys(input)\n      for (var k = 0; k < keys.length; k++) {\n        var key = keys[k]\n        res = res.concat([key]).concat(flattenInput(input[key]))\n      }\n    } else {\n      res = res.concat(input)\n    }\n  }\n  return res\n}\n\nmodule.exports = flattenInput\n\n\n//# sourceURL=webpack:///./node_modules/react-fetch-hook/utils/flattenInput.js?");

/***/ }),

/***/ "./node_modules/react-use-trigger/index.js":
/*!*************************************************!*\
  !*** ./node_modules/react-use-trigger/index.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var nanoid = __webpack_require__(/*! nanoid */ \"./node_modules/nanoid/index.browser.js\")\n\nfunction createTrigger () {\n  var trigger = function () {\n    trigger.id = nanoid()\n    trigger.subscribers.forEach(function (subscriber) {\n      subscriber()\n    })\n  }\n\n  trigger.id = nanoid()\n  trigger.subscribers = []\n\n  trigger.subscribe = function (f) {\n    trigger.subscribers.push(f)\n  }\n\n  trigger.unsubscribe = function (f) {\n    trigger.subscribers.indexOf(f) >= 0 &&\n    trigger.subscribers.splice(trigger.subscribers.indexOf(f), 1)\n  }\n\n  return trigger\n}\n\nmodule.exports = createTrigger\n\n\n//# sourceURL=webpack:///./node_modules/react-use-trigger/index.js?");

/***/ }),

/***/ "./node_modules/react-use-trigger/useTrigger.js":
/*!******************************************************!*\
  !*** ./node_modules/react-use-trigger/useTrigger.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("var React = __webpack_require__(/*! react */ \"react\")\n\nfunction useTrigger (trigger) {\n  var state = React.useState(trigger.id)\n\n  var update = function () { return state[1](trigger.id) }\n\n  React.useEffect(function () {\n    trigger.subscribe(update)\n    return function () { return trigger.unsubscribe(update) }\n  }, [])\n\n  return state[0]\n}\n\nmodule.exports = useTrigger\n\n\n//# sourceURL=webpack:///./node_modules/react-use-trigger/useTrigger.js?");

/***/ }),

/***/ "@wordpress/components":
/*!***************************************!*\
  !*** external "window.wp.components" ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = window.wp.components;\n\n//# sourceURL=webpack:///external_%22window.wp.components%22?");

/***/ }),

/***/ "@wordpress/element":
/*!************************************!*\
  !*** external "window.wp.element" ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = window.wp.element;\n\n//# sourceURL=webpack:///external_%22window.wp.element%22?");

/***/ }),

/***/ "blocksy-options":
/*!****************************************!*\
  !*** external "window.blocksyOptions" ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = window.blocksyOptions;\n\n//# sourceURL=webpack:///external_%22window.blocksyOptions%22?");

/***/ }),

/***/ "ct-events":
/*!**********************************!*\
  !*** external "window.ctEvents" ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = window.ctEvents;\n\n//# sourceURL=webpack:///external_%22window.ctEvents%22?");

/***/ }),

/***/ "ct-i18n":
/*!*********************************!*\
  !*** external "window.wp.i18n" ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = window.wp.i18n;\n\n//# sourceURL=webpack:///external_%22window.wp.i18n%22?");

/***/ }),

/***/ "react":
/*!*******************************!*\
  !*** external "window.React" ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("module.exports = window.React;\n\n//# sourceURL=webpack:///external_%22window.React%22?");

/***/ })

/******/ });