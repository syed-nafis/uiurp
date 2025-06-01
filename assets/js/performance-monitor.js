/**
 * Performance Monitor
 * Tracks and displays performance metrics for debugging
 */

class PerformanceMonitor {
    constructor() {
        this.metrics = {
            fps: 0,
            frameTime: 0,
            memoryUsage: 0,
            scrollEvents: 0,
            domQueries: 0,
            networkRequests: 0
        };
        
        this.isEnabled = localStorage.getItem('perfMonitor') === 'true' || 
                        window.location.search.includes('debug=true');
        
        if (this.isEnabled) {
            this.init();
        }
    }
    
    init() {
        this.createMonitorUI();
        this.startFPSMonitoring();
        this.startMemoryMonitoring();
        this.trackNetworkRequests();
        this.trackScrollEvents();
        this.trackDOMQueries();
        
        // Update display every second
        setInterval(() => this.updateDisplay(), 1000);
    }
    
    createMonitorUI() {
        const monitor = document.createElement('div');
        monitor.id = 'performance-monitor';
        monitor.className = 'perf-monitor';
        monitor.innerHTML = `
            <div class="perf-header">
                <span>Performance Monitor</span>
                <button onclick="window.perfMonitor.toggle()" style="background: none; border: none; color: white; cursor: pointer;">×</button>
            </div>
            <div class="perf-metrics">
                <div>FPS: <span id="fps-value">0</span></div>
                <div>Frame Time: <span id="frame-time-value">0</span>ms</div>
                <div>Memory: <span id="memory-value">0</span>MB</div>
                <div>Scroll Events: <span id="scroll-events-value">0</span></div>
                <div>DOM Queries: <span id="dom-queries-value">0</span></div>
                <div>Network: <span id="network-value">0</span></div>
            </div>
        `;
        
        document.body.appendChild(monitor);
        
        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .perf-monitor {
                position: fixed;
                top: 10px;
                right: 10px;
                background: rgba(0, 0, 0, 0.9);
                color: white;
                padding: 10px;
                border-radius: 8px;
                font-family: 'Courier New', monospace;
                font-size: 11px;
                z-index: 10000;
                min-width: 200px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .perf-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
                font-weight: bold;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                padding-bottom: 4px;
            }
            
            .perf-metrics div {
                margin: 2px 0;
                display: flex;
                justify-content: space-between;
            }
            
            .perf-metrics span {
                color: #4cc9f0;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);
    }
    
    startFPSMonitoring() {
        let frames = 0;
        let lastTime = performance.now();
        let frameTimeSum = 0;
        
        const measureFPS = (currentTime) => {
            frames++;
            const frameTime = currentTime - lastTime;
            frameTimeSum += frameTime;
            
            if (frames >= 60) {
                this.metrics.fps = Math.round(1000 / (frameTimeSum / frames));
                this.metrics.frameTime = Math.round(frameTimeSum / frames * 100) / 100;
                frames = 0;
                frameTimeSum = 0;
            }
            
            lastTime = currentTime;
            requestAnimationFrame(measureFPS);
        };
        
        requestAnimationFrame(measureFPS);
    }
    
    startMemoryMonitoring() {
        if ('memory' in performance) {
            setInterval(() => {
                this.metrics.memoryUsage = Math.round(
                    performance.memory.usedJSHeapSize / 1024 / 1024
                );
            }, 1000);
        }
    }
    
    trackNetworkRequests() {
        const originalFetch = window.fetch;
        const originalXHR = window.XMLHttpRequest;
        
        // Track fetch requests
        window.fetch = (...args) => {
            this.metrics.networkRequests++;
            return originalFetch.apply(this, args);
        };
        
        // Track XMLHttpRequest
        window.XMLHttpRequest = function() {
            const xhr = new originalXHR();
            const originalSend = xhr.send;
            
            xhr.send = function(...args) {
                window.perfMonitor.metrics.networkRequests++;
                return originalSend.apply(this, args);
            };
            
            return xhr;
        };
    }
    
    trackScrollEvents() {
        let scrollCount = 0;
        
        window.addEventListener('scroll', () => {
            scrollCount++;
        }, { passive: true });
        
        setInterval(() => {
            this.metrics.scrollEvents = scrollCount;
            scrollCount = 0;
        }, 1000);
    }
    
    trackDOMQueries() {
        const originalQuerySelector = document.querySelector;
        const originalQuerySelectorAll = document.querySelectorAll;
        const originalGetElementById = document.getElementById;
        
        let queryCount = 0;
        
        document.querySelector = function(...args) {
            queryCount++;
            return originalQuerySelector.apply(this, args);
        };
        
        document.querySelectorAll = function(...args) {
            queryCount++;
            return originalQuerySelectorAll.apply(this, args);
        };
        
        document.getElementById = function(...args) {
            queryCount++;
            return originalGetElementById.apply(this, args);
        };
        
        setInterval(() => {
            this.metrics.domQueries = queryCount;
            queryCount = 0;
        }, 1000);
    }
    
    updateDisplay() {
        if (!this.isEnabled) return;
        
        const fpsElement = document.getElementById('fps-value');
        const frameTimeElement = document.getElementById('frame-time-value');
        const memoryElement = document.getElementById('memory-value');
        const scrollElement = document.getElementById('scroll-events-value');
        const domElement = document.getElementById('dom-queries-value');
        const networkElement = document.getElementById('network-value');
        
        if (fpsElement) fpsElement.textContent = this.metrics.fps;
        if (frameTimeElement) frameTimeElement.textContent = this.metrics.frameTime;
        if (memoryElement) memoryElement.textContent = this.metrics.memoryUsage;
        if (scrollElement) scrollElement.textContent = this.metrics.scrollEvents;
        if (domElement) domElement.textContent = this.metrics.domQueries;
        if (networkElement) networkElement.textContent = this.metrics.networkRequests;
        
        // Color code FPS
        if (fpsElement) {
            if (this.metrics.fps >= 55) {
                fpsElement.style.color = '#10b981'; // Green
            } else if (this.metrics.fps >= 30) {
                fpsElement.style.color = '#f59e0b'; // Yellow
            } else {
                fpsElement.style.color = '#ef4444'; // Red
            }
        }
        
        // Color code memory usage
        if (memoryElement && this.metrics.memoryUsage > 100) {
            memoryElement.style.color = '#ef4444'; // Red for high memory usage
        }
    }
    
    toggle() {
        this.isEnabled = !this.isEnabled;
        localStorage.setItem('perfMonitor', this.isEnabled.toString());
        
        const monitor = document.getElementById('performance-monitor');
        if (monitor) {
            monitor.style.display = this.isEnabled ? 'block' : 'none';
        }
    }
    
    getMetrics() {
        return { ...this.metrics };
    }
    
    logPerformanceReport() {
        console.group('Performance Report');
        console.log('FPS:', this.metrics.fps);
        console.log('Frame Time:', this.metrics.frameTime + 'ms');
        console.log('Memory Usage:', this.metrics.memoryUsage + 'MB');
        console.log('Scroll Events/sec:', this.metrics.scrollEvents);
        console.log('DOM Queries/sec:', this.metrics.domQueries);
        console.log('Network Requests:', this.metrics.networkRequests);
        
        // Performance recommendations
        console.group('Recommendations');
        if (this.metrics.fps < 30) {
            console.warn('Low FPS detected. Consider reducing animations or particle count.');
        }
        if (this.metrics.memoryUsage > 100) {
            console.warn('High memory usage detected. Check for memory leaks.');
        }
        if (this.metrics.scrollEvents > 100) {
            console.warn('High scroll event frequency. Consider throttling scroll handlers.');
        }
        if (this.metrics.domQueries > 50) {
            console.warn('High DOM query frequency. Consider caching DOM elements.');
        }
        console.groupEnd();
        console.groupEnd();
    }
}

// Initialize performance monitor
const perfMonitor = new PerformanceMonitor();

// Export for global use
window.PerformanceMonitor = PerformanceMonitor;
window.perfMonitor = perfMonitor;

// Add keyboard shortcut to toggle monitor (Ctrl+Shift+P)
document.addEventListener('keydown', (e) => {
    if (e.ctrlKey && e.shiftKey && e.key === 'P') {
        e.preventDefault();
        perfMonitor.toggle();
    }
});

// Add console command to get performance report
window.getPerformanceReport = () => perfMonitor.logPerformanceReport(); 