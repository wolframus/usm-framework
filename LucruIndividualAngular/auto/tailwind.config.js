/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./assets/**/*.js', './templates/**/*.html.twig', './src/form/**/*.php'],
  theme: {
    extend: {},
    fontFamily: {
      sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      mono: [
        'ui-monospace',
        'SFMono-Regular',
        'Menlo',
        'Monaco',
        'Consolas',
        'Liberation Mono',
        'Courier New',
        'monospace',
      ],
      serif: ['Lora', 'ui-serif', 'Georgia', 'Cambria', 'Times New Roman', 'Times, serif'],
    },
  },
  plugins: [require('@tailwindcss/line-clamp')],
};
