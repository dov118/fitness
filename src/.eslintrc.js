const config = {
    env: {
        es2021: true,
        browser: true,
        node: true,
        jquery: true,
    },
    extends: [
        'airbnb-base',
        'plugin:import/typescript',
    ],
    parser: '@typescript-eslint/parser',
    parserOptions: {
        ecmaVersion: 12,
        sourceType: 'module',
    },
    plugins: [
        '@typescript-eslint',
    ],
    rules: {
        'max-len': 0,
        'import/extensions': 0,
        'import/no-unresolved': 0,
        'func-names': 0,
        'no-undef': 0,
    },
};

if (process.env.npm_lifecycle_event === 'prod') {
    if (config.rules === undefined) {
        config.rules = {};
    }

    config.rules['no-console'] = 'error';
}

module.exports = config;
