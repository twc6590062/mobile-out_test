
#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

// 扇形遮罩的起始、结束角度、圆形中点、是否顺时针裁剪
uniform float u_mask_beg;
uniform float u_mask_end;
uniform int   u_clockwise;
uniform int   u_erase;
uniform vec2  u_center;

void main()
{
    // 纹理坐标为左上角，这里先转为以center为中点的笛卡尔坐标系
    vec2 transform = vec2(v_texCoord.x - u_center.x, u_center.y - v_texCoord.y);

    // 计算与x轴角度
    float degree = 0.0;

    if (transform.x != 0.0)
    {
        degree = atan(transform.y / transform.x) / 3.1415926 * 180.0;
    }

    gl_FragColor = vec4(0.0, 1.0, 0.0, 1.0);

    // 4个轴、4个象限、1个中心点
    if ((transform.x > 0.0) && (transform.y == 0.0))
    {
        degree = 0.0;
    }
    else if ((transform.x > 0.0) && (transform.y > 0.0))
    {
        // pass
    }
    else if ((transform.x == 0.0) && (transform.y > 0.0))
    {
        degree = 90.0;
    }
    else if ((transform.x < 0.0) && (transform.y > 0.0))
    {
        degree += 180.0;
    }
    else if ((transform.x < 0.0) && (transform.y == 0.0))
    {
        degree = 180.0;
    }
    else if ((transform.x < 0.0) && (transform.y < 0.0))
    {
        degree += 180.0;
    }
    else if ((transform.x == 0.0) && (transform.y < 0.0))
    {
        degree = 270.0;
    }
    else if ((transform.x > 0.0) && (transform.y < 0.0))
    {
        degree += 360.0;
    }

    // 判断裁剪，在范围之外被丢弃
    float degree_beg = u_mask_beg;
    float degree_end = u_mask_end;

    bool is_equal = (degree_beg == degree_end);

    // 如果角度是负数，要加上360
    if (degree_beg < 0.0)
    {
        degree_beg += 360.0;
    }

    if (degree_end < 0.0)
    {
        degree_end += 360.0;
    }

    // 判断裁剪
    bool clip = u_erase != 0;

    if (is_equal)
    {
        // 90 ~ 90这样的
        clip = u_erase == 0;
    }
    else if (u_clockwise != 0)
    {
        if (degree_end < degree_beg)
        {
            // 90 ~ 30这样的
            if ((degree < degree_end) || (degree > degree_beg))
            {
                clip = u_erase == 0;
            }
        }
        else
        {
            // 30 ~ -30这样的
            if ((degree > degree_beg) && (degree < degree_end))
            {
                clip = u_erase == 0;
            }
        }
    }
    else
    {
        if ((degree < degree_beg) || (degree > degree_end))
        {
            clip = u_erase == 0;
        }
    }

    if (clip)
    {
        discard;
    }
    else
    {
        vec4   color = v_fragmentColor * texture2D(CC_Texture0, v_texCoord);
        gl_FragColor = vec4(color.r, color.g, color.b, color.a);
    }
}