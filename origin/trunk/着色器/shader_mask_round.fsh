#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

uniform vec2 u_bl;
uniform vec2 u_tr;
uniform float u_hPer;            //显示的高度比例
uniform int u_color;             //颜色选择 0 默认（黄），1 红，2 绿
uniform float u_scale;           //scale
uniform float u_percent;

float ys;

void main()
{
    float radius;

    float width = u_tr.x - u_bl.x;
    float height = u_bl.y - u_tr.y;
    if(width>height)
    {
        radius = width/2.0;
    }
    else
    {
        radius = height/2.0;
    }
    radius *= u_scale;
    vec2 center = vec2(u_tr.x - width/2.0, u_tr.y + height/2.0);

    // 纹理坐标为左上角，这里先转为以center为中点的笛卡尔坐标系
    float per;
    vec2 transform;
    if(width>height)
    {
        per = width/height;
        transform = vec2(v_texCoord.x - center.x, (v_texCoord.y - center.y)*per);
    }
    else
    {
        per = height/width;
        transform = vec2((v_texCoord.x - center.x)*per, v_texCoord.y - center.y);
    }

    // 计算与圆中心的距离
    float dis = sqrt(transform.x * transform.x + transform.y * transform.y);

    // 计算当前坐标 在高度上的比例
    float hPer = (u_bl.y - v_texCoord.y) / height;

    // 计算显示的像素点的y坐标
    float y = u_tr.y + u_hPer * height - (u_bl.y - v_texCoord.y) + u_percent * height;
    // float y = v_texCoord.y;

    // 判断是否在圆外
    if (dis > radius)
    {
        discard;
    }
    // 判断是否超出高度比例
    else if (hPer > u_hPer)
    {
        discard;
    }
    else
    {
        vec4 color = v_fragmentColor * texture2D(CC_Texture0, vec2(v_texCoord.x , y));
        if(u_color == 0)
        {
            gl_FragColor = vec4(color.r , color.g , color.b , color.a);
        }
        else if(u_color == 1)
        {
            gl_FragColor = vec4(color.r , color.b/2.0 , color.b/2.0 , color.a);
        }
        else if(u_color == 2)
        {
            gl_FragColor = vec4(color.r/3.0 , color.r , color.b , color.a);
        }
        else
        {
            discard;
        }
    }
}