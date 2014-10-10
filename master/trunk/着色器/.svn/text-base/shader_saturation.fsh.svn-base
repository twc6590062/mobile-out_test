#ifdef GL_ES
precision mediump float;
#endif

varying vec4 v_fragmentColor;
varying vec2 v_texCoord;
uniform float f_saturation;  //饱和度

// 参考 http://zh.wikipedia.org/wiki/HSL%E5%92%8CHSV%E8%89%B2%E5%BD%A9%E7%A9%BA%E9%97%B4



// ================== HSL ==================

float getColorPart(in float p, in float q, in float tc){
	if(tc < 0.16666667){

		return p + (( q - p) * 6.0 * tc);

	}else if(tc >= 0.16666667 && tc < 0.5){

		return q ;

	}else if( tc >= 0.5 && tc < 0.66666667 ){

		return p + (( q - p) * 6.0 * ( 0.66666667 - tc));

	}else{

		return p;
	}


	if(tc < 0.16666667){
		return p + (( q - p) * 6.0 * tc);
	}
}

float fix(in float i){
	if(i < 0.0){
	 	return i + 1.0;
	}

	if(i > 0.0) return  i - 1.0;

	return i;
}


float getq(in float l, in float s){
	if( l < 0.5){
		return l * (1.0 + s);
	}

	if( l >= 0.5){
		return l + s -  (l * s);
	}
}


// 获得色相
float getHByColor(in vec4 color, in float max, in float min){
	if(max == min){
		return 0.;
	}

	if(max == color.r &&  color.g >= color.b){
		return 60. * (color.g - color.b) / (max - min);
	}

	if(max == color.r &&  color.g < color.b){
		return 60. * (color.g - color.b) / (max - min) + 360.;
	}

	if(max == color.g){
		return 60. * (color.b- color.r) / (max - min) + 120.;
	}

	if(max == color.b){
		return 60. * (color.g- color.r) / (max - min) + 240.;
	}

}

// 获得亮度
float getLByColor(in float max, in float min){
	
	return 0.5 * (max + min);
}


// ================== HSV ==================

vec3 convertRGB2HSV( in vec3 rgbcolor){
	float h, s, v;
	float r = rgbcolor.r;
	float g = rgbcolor.g;
	float b = rgbcolor.b;
	float maxval = max(r, max(g, b));
	v = maxval;
	float minval = min(r, min(g, b));
	if(maxval == 0. ) s = 0.0;
	else s = (maxval - minval) / maxval;

	if(s == 0.0) h = 0.;
	else{
	 	float delta = maxval - minval;
	 	if(r == maxval )
	 	 	h = (g - b) / delta;
	 	else 
	 		if( g == maxval) h = 2.0 + (b - r) / delta;
	 		else 
	 		if( b == maxval) h = 4.0 + (r - g) / delta;

		h *= 60.;

		if(h < 0.0) h += 360.;
	}

	return vec3(h, s, v);

}

vec3 convertHSV2RGB( in vec3 hsvcolor){
	
	float h = hsvcolor.x;
	float s = hsvcolor.y;
	float v = hsvcolor.z;

	if(s == 0.0){
		return vec3(v,v,v);
	}

	else{

		if(h > 360.) h = 360.;
		if(h < 0.0) h = 0.0;
		h /= 60.;
		int k = int(h);

		float f = h - float(k);
		float p = v * (1.0 - s);
		float q = v * (1.0 - ( s - f));
		float t = v * (1.0 - (s * ( 1.0 - f)));

		if(k == 0) return vec3(v, t, p);
		if(k == 1) return vec3(q, v, p);
		if(k == 2) return vec3(p, v, t);
		if(k == 3) return vec3(p, q, v);
		if(k == 4) return vec3(t, p, v);
		if(k == 5) return vec3(v, p, q);
		

	}

}

void main()
{
	
 	vec4 color 		= texture2D(CC_Texture0, v_texCoord); 

 	float max = max(color.r , max(color.g, color.b));
 	float min = min(color.r , min(color.g, color.b));

 	float h = getHByColor(color,max, min);
 	float l = getLByColor(max, min);

 	if(f_saturation == 0.0){
 		
 		color.r = l;
	    color.g = l;
	    color.b = l;

 	}else{

 		float q = getq(l, f_saturation);
	 	float p = 2.0 * l - q;

	 	float hk = h / 360.;

	    float tr = hk + 0.33333333;
	    float tg = hk;
	    float tb = hk -  0.33333333;

	    tr = fix(tr);
	    tg = fix(tg);
	    tb = fix(tb);

	    color.r = getColorPart(p, q , tr);
	    color.g = getColorPart(p, q , tg);
	    color.b = getColorPart(p, q , tb);

 	}

 	// vec4 color0 		= texture2D(CC_Texture0, v_texCoord); 
 	// vec3 color 			= color0.rgb;
 	//vec3 hsv = convertRGB2HSV(color);
 	//hsv.y = f_saturation;

 	//color = convertHSV2RGB(hsv);
 	//vec4 color2 = vec4(hsv, color0.w);

 	gl_FragColor	= v_fragmentColor * color;

}


