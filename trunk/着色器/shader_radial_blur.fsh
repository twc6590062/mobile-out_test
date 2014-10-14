#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;

uniform float f_sample_dist;
uniform float f_sample_strength;
const vec2 texture_center = vec2(0.5, 0.5);
void main()
{
	vec2 dir 		= texture_center - v_texCoord ; 
	float dist 		= length(dir);  
	dir 			= normalize(dir);

	vec4 color 		= texture2D(CC_Texture0, v_texCoord);  
    vec4 sum 		= color;  
    
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * -0.08 * f_sample_dist  );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * -0.05 * f_sample_dist  );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * -0.03 * f_sample_dist );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * -0.02 * f_sample_dist  );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * -0.01 * f_sample_dist );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * 0.01  * f_sample_dist );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * 0.02  * f_sample_dist );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * 0.03  * f_sample_dist );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * 0.05  * f_sample_dist );  
    sum +=  texture2D(CC_Texture0, v_texCoord + dir * 0.08  * f_sample_dist );  

   	sum 			= sum / 11.0;
  	float  t 		= clamp(dist * f_sample_strength, 0.0, 1.0);
  	color 			= color + t * (sum - color);

  	gl_FragColor	= v_fragmentColor * color;
  
}
