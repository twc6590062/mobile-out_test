#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

void main()
{
  // 这个地方就是采用一个特定比例中和RGB，获取灰度值，这样可以得到真实感比较好的黑白图像
  // convert to grayscale using recommended method: http://en.wikipedia.org/wiki/Grayscale#Converting_color_to_grayscale
  vec4   color = texture2D(CC_Texture0, v_texCoord);
  float  gray  = color.r * 0.3 + color.g * 0.59 + color.b * 0.11;
  gl_FragColor = vec4(gray, gray, gray, color.a) * v_fragmentColor;
}