module.exports = {
    important: true,
    // Active dark mode on class basis
    // darkMode: 'media',
    purge: [
        './resources/views/**/*.blade.php',
        './resources/css/**/*.css',
    ],
    theme: {},
    variants: {},
    plugins: [
        require('@tailwindcss/ui'),
        require('@tailwindcss/custom-forms'),
    ]
}
