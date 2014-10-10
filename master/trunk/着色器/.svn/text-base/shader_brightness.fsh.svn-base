#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;
uniform float f_brightness;

void main()
{
  // 原始颜色值的某个倍数就会有变亮的效果
  vec4   color = v_fragmentColor * texture2D(CC_Texture0, v_texCoord) * f_brightness;
  gl_FragColor = vec4(color.r, color.g, color.b, color.a);
}