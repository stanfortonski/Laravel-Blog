module.exports = {
    verbose: true,
    setupFilesAfterEnv: ['<rootDir>/resources/js/setupTests.js'],
    moduleFileExtensions: [
        'js',
        'json',
        'vue'
    ],
    transform: {
        "^.+\\.js$": 'babel-jest'
    }
}
