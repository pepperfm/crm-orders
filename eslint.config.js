import antfu from '@antfu/eslint-config'

export default antfu({
  vue: true,
  stylistic: {
    'max-attributes-per-line': ['error', {
      singleline: 1,
      multiline: 1,
    }],
    'vue/max-attributes-per-line': ['error', {
      singleline: 1,
      multiline: 1,
    }],
  },
})
// .override(
//   'stylistic',
//   {
//     rules: {
//       'brace-style': ['1tbs'],
//     }
//   }
// )
