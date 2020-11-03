"use strict";

class LiquidSlider {
	constructor(container, options = {}) {
		['render', 'changeTexture'].forEach(fn => this[fn] = this[fn].bind(this))

		this.container = container;
		this.animating = false;
		this.initStatus = true;
		this.threeContainer = container.querySelector('.images-slider-wrapper');
		this.swiperContainer = container.querySelector('.swiper-container');
		this.contentSlider = container.querySelector('.content-slider-container');
		this.contentSliderItems = this.contentSlider.querySelectorAll('.content-slide');
		this.images = container.querySelectorAll('img');
		this.options = options;
		this.direction = true; // Next if true
		this.renderer = null;
		this.resizeTimeout = '';
		this.slides = [];
		this.vert = `
		varying vec2 vUv;
		void main() {
			vUv = uv;
			gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
		}
		`

		this.frag = `
		varying vec2 vUv;

		uniform sampler2D texture1;
		uniform sampler2D texture2;
		uniform sampler2D disp;

		uniform float dispPower;
		uniform float intensity;

		uniform vec2 screenSize;
		uniform vec2 imageSize;
		
		vec2 backgroundCoverUv( vec2 screenSize, vec2 imageSize, vec2 uv ) {
			float screenRatio = screenSize.x / screenSize.y;
			float imageRatio = imageSize.x / imageSize.y;
			vec2 newSize = screenRatio < imageRatio 
					? vec2(imageSize.x * (screenSize.y / imageSize.y), screenSize.y)
					: vec2(screenSize.x, imageSize.y * (screenSize.x / imageSize.x));
			vec2 newOffset = (screenRatio < imageRatio 
					? vec2((newSize.x - screenSize.x) / 2.0, 0.0) 
					: vec2(0.0, (newSize.y - screenSize.y) / 2.0)) / newSize;
			return uv * screenSize / newSize + newOffset;
		}

		void main() {

			vec2 uv = backgroundCoverUv(screenSize, imageSize, vUv);
			vec4 disp = texture2D(disp, uv);
			vec2 dispVec = vec2(disp.x, disp.y);

			
			vec2 distPos1 = vec2(uv.x + dispPower * (disp.r*intensity), uv.y);
			vec2 distPos2 = vec2(uv.x - (1.0 - dispPower) * (disp.r*intensity), uv.y);
			
			vec4 _texture1 = texture2D(texture1, distPos1);
			vec4 _texture2 = texture2D(texture2, distPos2);
			
			gl_FragColor = mix(_texture1, _texture2, dispPower);
		}
		`

		this.init();

		container.querySelector('.next').addEventListener('click', () => {
			console.log('click by button');
			console.log(this);
		});
	}

	init() {
		this.setContainerSize()
		this.initSwiper()
		this.initThree()
		this.texturesLoader()
	}

	initSwiper() {
		let options = this.options;
		this.swiper = new Swiper(this.swiperContainer, {
			loop: true,
			speed: 2800,
			init: false,
			longSwipes: false,
			touchStartPreventDefault: false,
			//effect: 'fade',
			//allowTouchMove: false,
			autoplay: options.autoplay == 'on' && {
				delay: options.autoplaySpeed
			},
			navigation: {
				nextEl: this.container.querySelector('.next'),
				prevEl: this.container.querySelector('.prev'),
			},
			on: {
				init: () => {},
				resize: () => {
					this.resize();
				},
				transitionStart: () => {},
				slideChange: () => {},
				slideChangeTransitionStart: () => {
					this.setSlideColorScheme();
					this.slideTransition();
					this.setActiveSlide();
					this.swiper.params.allowTouchMove = false
					this.swiperContainer.style.pointerEvents = 'none'
				},
				slideChangeTransitionEnd: () => {
					this.swiperContainer.style.pointerEvents = 'all'
				},
				sliderMove: (swiper) => {
					let index = swiper.snapIndex,
					grid = swiper.snapGrid[index],
					offset = grid - swiper.translate;
				},
				slidePrevTransitionStart: () => {},
				transitionEnd: () => {
					this.swiper.params.allowTouchMove = true
				}
			}
		});
		this.swiper.init();
	}

	initThree() {
		this.scene = new THREE.Scene()
		this.camera = new THREE.OrthographicCamera(
			this.threeContainer.offsetWidth / -2,
			this.threeContainer.offsetWidth / 2,
			this.threeContainer.offsetHeight / 2,
			this.threeContainer.offsetHeight / -2,
			1,
			1000
		);

		this.camera.position.z = 1;

		this.renderer = new THREE.WebGLRenderer({
			antialias: false,
			// alpha: true
		});

		this.renderer.setPixelRatio(window.devicePixelRatio);
		this.renderer.setClearColor(0xffffff, 0.0);
		this.renderer.setSize(this.threeContainer.offsetWidth, this.threeContainer.offsetHeight);
		this.threeContainer.appendChild(this.renderer.domElement);

		this.render()
	}

	initShader() {
		this.mat = new THREE.ShaderMaterial({
			uniforms: {
				dispPower: {
					type: 'f',
					value: 0.0
				},
				intensity: {
					type: 'f',
					value: 0.2
				},
				screenSize: {
					value: new THREE.Vector2(this.threeContainer.offsetWidth, this.threeContainer.offsetHeight)
				},
				imageSize: {
					value: new THREE.Vector2(this.textures[0].image.naturalWidth, this.textures[0].image.naturalHeight)
				},
				texture1: {
					type: 't',
					value: this.textures[0]
				},
				texture2: {
					type: 't',
					value: this.textures[1]
				},
				disp: {
					type: 't',
					value: this.disp
				}
			},
			transparent: true,
			vertexShader: this.vert,
			fragmentShader: this.frag
		})

		const geometry = new THREE.PlaneBufferGeometry(
			this.threeContainer.offsetWidth,
			this.threeContainer.offsetHeight,
			1
		)

		const mesh = new THREE.Mesh(geometry, this.mat)

		this.scene.add(mesh);

		this.render()
	}

	texturesLoader() {
		const loader = new THREE.TextureLoader()
		loader.crossOrigin = ''

		this.textures = []
		this.images.forEach((image, index) => {

			const texture = loader.load(image.src, () => {
				if (index == 0) {
					this.initShader()
				}
				this.render()
			})

			texture.minFilter = THREE.LinearFilter
			texture.generateMipmaps = false

			this.textures.push(texture)
		})

		this.disp = loader.load(this.container.getAttribute('data-displacement'), this.render())
		this.disp.magFilter = this.disp.minFilter = THREE.LinearFilter
		this.disp.wrapS = this.disp.wrapT = THREE.RepeatWrapping
	}

	getWindowSize() {
		let coef = 0,
			wpadminbar = document.getElementById('wpadminbar');

		if (wpadminbar) {
			coef = wpadminbar.offsetHeight;
		}

		return {
			width: window.innerWidth,
			height: window.innerHeight - coef
		}
	}

	setContainerSize() {
		let windowSize = this.getWindowSize();

		this.container.style.width = windowSize.width + 'px';
		this.container.style.height = windowSize.height + 'px';
	}

	resize() {
		let windowSize = this.getWindowSize();

		this.setContainerSize()

		this.container.querySelectorAll('.swiper-container .container').forEach((item) => {
			item.style.height = windowSize.height + 'px';
		});

		this.renderer.setSize(windowSize.width, windowSize.height);
		this.camera.aspect = windowSize.width / windowSize.height;
		this.camera.updateProjectionMatrix();
		this.mat.uniforms.screenSize.value = [windowSize.width, windowSize.height];

		this.render()
	}

	setSlideColorScheme() {
		let currentSlide = this.swiper.slides[this.swiper.activeIndex];

		if (currentSlide.classList.contains('current-color-black')) {
			this.swiperContainer.classList.add('black-color')
			this.swiperContainer.classList.remove('white-color')
		} else if (currentSlide.classList.contains('current-color-white')) {
			this.swiperContainer.classList.add('white-color')
			this.swiperContainer.classList.remove('black-color')
		} else {
			this.swiperContainer.classList.remove('white-color')
			this.swiperContainer.classList.remove('black-color')
		}
	}

	setActiveSlide() {
		this.contentSliderItems.forEach((item, index) => {
			this.swiper.realIndex == index ? item.classList.add('slide-active') : item.classList.remove('slide-active');
		});
	}

	render() {
		this.renderer.render(this.scene, this.camera)
	}

	changeTexture() {
		this.mat.uniforms.texture1.value = this.textures[this.swiper.previousIndex - this.swiper.loopedSlides]
		this.mat.uniforms.texture2.value = this.textures[this.swiper.realIndex]
	}

	changeSlideRatio(duration) {
		gsap.to(this.mat.uniforms.imageSize.value, {
			duration,
			x: this.textures[this.swiper.realIndex].image.naturalWidth,
			y: this.textures[this.swiper.realIndex].image.naturalHeight,
			ease: Expo.easeInOut,
		})

		this.render()
	}

	resetValuesAfterAnimation() {
		this.animating = false;
		this.mat.uniforms.dispPower.value = 0.0
		this.mat.uniforms.texture1.value = this.mat.uniforms.texture2.value;

		this.render()
	}

	slideTransition() {
		if (this.initStatus) {
			this.initStatus = false;
			return;
		}

		console.log(this.animating);

		if (this.animating) return;

		let index = this.swiper.realIndex,
			nextImage = this.slides[index],
			contentSlidePrev = this.contentSliderItems[this.swiper.previousIndex - this.swiper.loopedSlides].querySelector('.content'),
			contentSlideNext = this.contentSliderItems[this.swiper.realIndex].querySelector('.content'),
			playButtonPrev = this.contentSliderItems[this.swiper.previousIndex - this.swiper.loopedSlides].querySelector('.play-button-block'),
			playButtonNext = this.contentSliderItems[this.swiper.realIndex].querySelector('.play-button-block');

		this.timeLine = new TimelineMax({
			onStart: () => {
				this.animating = true;
			},
			onComplete: () => {
				this.resetValuesAfterAnimation()
			}
		});

		this.direction = this.swiper.activeIndex > this.swiper.previousIndex;

		!this.direction ? this.mat.uniforms.intensity.value = -0.2 : this.mat.uniforms.intensity.value = 0.2

		this.timeLine.fromTo(this.renderer.domElement, .5, {
				transform: 'scale(1)'
			}, {
				transform: 'scale(1.02)'
			}, 0)
			.to(this.renderer.domElement, 1, {
				delay: .8,
				transform: 'scale(1)',
			}, 1)
			.to(this.mat.uniforms.dispPower, 2, {
				value: 1,
				ease: Expo.easeInOut,
				onUpdate: this.render,
				onStart: () => {
					this.changeTexture()
					this.changeSlideRatio(2)
				},
				onComplete: () => {}
			}, 0)
			.fromTo(contentSlidePrev, .8, {
				x: 0,
				alpha: 1
			}, {
				x: this.direction ? '-50%' : '50%',
				alpha: 0,
				delay: .5,
				ease: 'Expo.easeInOut'
			}, 0)
			.fromTo(contentSlideNext, .8, {
				x: this.direction ? '50%' : '-50%',
				alpha: 0,
			}, {
				x: 0,
				alpha: 1,
				delay: .5,
				ease: 'Expo.easeInOut'
			}, 0)

		if (playButtonPrev) {
			this.timeLine.fromTo(playButtonPrev, 1.2, {
				x: 0,
				opacity: 1,
			}, {
				delay: .2,
				x: this.direction ? -140 : 140,
				opacity: 0,
				ease: 'Expo.easeInOut',
				onStart: () => {
					playButtonPrev.style.visibility = 'visible'
				},
				onComplete: () => {
					playButtonPrev.style.visibility = 'hidden'
				}
			}, 0)
		}

		if (playButtonNext) {
			this.timeLine.fromTo(playButtonNext, 1.2, {
				x: this.direction ? 140 : -140,
				opacity: 0,
			}, {
				delay: .2,
				x: 0,
				opacity: 1,
				ease: 'Expo.easeInOut',
				onStart: () => {
					playButtonNext.style.visibility = 'visible'
				},
			}, 0)
		}
		console.log(this.timeLine.duration());
	}
}