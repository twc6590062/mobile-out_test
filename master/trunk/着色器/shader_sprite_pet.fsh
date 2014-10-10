#ifdef GL_ES
    precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

// 纹理的原点在左上角，往右、往下增长
uniform vec2 u_mask_bl;  // 左下角
uniform vec2 u_mask_tr;  // 右上角

void main()
{
    vec4 color = texture2D(CC_Texture0, v_texCoord);

    // 在矩形范围内彩色显示，不在的话灰度显示
    if ((v_texCoord.x < u_mask_bl.x) ||
        (v_texCoord.x > u_mask_tr.x) ||
        (v_texCoord.y > u_mask_bl.y) ||
        (v_texCoord.y < u_mask_tr.y))
    {
        float  gray  = color.r * 0.3 + color.g * 0.59 + color.b * 0.11;
        gl_FragColor = vec4(gray, gray, gray, color.a) * v_fragmentColor;
    }
    else
    {
        gl_FragColor = vec4(color.r, color.g, color.b, color.a) * v_fragmentColor;
    }
}