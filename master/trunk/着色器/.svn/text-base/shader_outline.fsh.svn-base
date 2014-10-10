#ifdef GL_ES
    precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

// 1像素对应的纹理宽高
uniform float u_unit_x;
uniform float u_unit_y;

void main()
{
    vec4 color = texture2D(CC_Texture0, v_texCoord);

    if (color.a < 0.45)
    {
        // 扫描四周，如果有不透明像素则绘制描边
        vec4 probe_l = texture2D(CC_Texture0, vec2(v_texCoord.x - u_unit_x, v_texCoord.y));
        vec4 probe_t = texture2D(CC_Texture0, vec2(v_texCoord.x,            v_texCoord.y - u_unit_y));
        vec4 probe_r = texture2D(CC_Texture0, vec2(v_texCoord.x + u_unit_x, v_texCoord.y));
        vec4 probe_b = texture2D(CC_Texture0, vec2(v_texCoord.x + u_unit_x, v_texCoord.y + u_unit_y));

        float max_alpha = probe_l.a;

        if (probe_t.a > max_alpha)
        {
            max_alpha = probe_t.a;
        }

        if (probe_r.a > max_alpha)
        {
            max_alpha = probe_r.a;
        }

        if (probe_b.a > max_alpha)
        {
            max_alpha = probe_b.a;
        }

        if (max_alpha != 0.0)
        {
            float alpha = 0.0;

            // if (color.a >= 0.1)
            // {
            //     alpha = 1.0;
            // }
            // else
            // {
            //     alpha = 0.02;
            // }

            color = vec4(150.0 / 255.0, 150.0 / 255.0, 150.0 / 255.0, 1.0);
        }
    }

    gl_FragColor = v_fragmentColor * color;
}