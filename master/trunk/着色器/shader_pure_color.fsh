#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;
uniform vec3 u_pureColor;

void main()
{
  vec4   color = v_fragmentColor * texture2D(CC_Texture0, v_texCoord);
  gl_FragColor = vec4(u_pureColor.r, u_pureColor.g, u_pureColor.b, color.a);
}