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
    // 在矩形范围内才能显示，不在的话就丢弃
    if ((v_texCoord.x < u_mask_bl.x) ||
        (v_texCoord.x > u_mask_tr.x) ||
        (v_texCoord.y > u_mask_bl.y) ||
        (v_texCoord.y < u_mask_tr.y))
    {
        discard;
    }
    else
    {
        vec4   color = v_fragmentColor * texture2D(CC_Texture0, v_texCoord);
        gl_FragColor = vec4(color.r, color.g, color.b, color.a);
    }
}