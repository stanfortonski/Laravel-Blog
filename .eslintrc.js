module.exports = {
    "env": {
        "browser": true,
        "node" : true
    },
    "extends": [
        "eslint:recommended",
    ],
    "parserOptions": {
        "sourceType": "module",
        "parser": "babel-eslint",
        "ecmaVersion": 2015
    },
    "plugins": [],
    "rules": {
        "no-unused-vars": "warn"
    }
};
