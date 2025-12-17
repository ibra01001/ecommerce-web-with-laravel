<!-- Quick Buy Modal Component -->
<div id="globalQuickBuyModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 relative">
        <button type="button" onclick="closeGlobalQuickBuy()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h3 class="text-2xl font-light text-slate-900 mb-6" id="modalProductName">Quick Add</h3>

        <form id="globalQuickBuyForm" method="POST" action="" class="space-y-6">
            @csrf
            
            <div id="sizeOptionsContainer" class="hidden space-y-3">
                <label class="text-sm text-slate-700 font-medium">Select Size</label>
                <div id="sizeOptionsGrid" class="grid grid-cols-3 gap-2">
                    <!-- Options will be dynamically inserted -->
                </div>
                <input type="hidden" name="stock_option_id" id="globalOptionHidden">
                <p id="globalOptionError" class="text-sm text-rose-500 hidden">Please select a size</p>
            </div>

            <div class="space-y-3">
                <label class="text-sm text-slate-700 font-medium">Quantity</label>
                <div class="flex items-center gap-4">
                    <div class="inline-flex items-center border-2 rounded-lg overflow-hidden border-slate-200">
                        <button type="button" onclick="changeGlobalQty(-1)" class="px-4 py-2 text-slate-700 hover:bg-slate-50">-</button>
                        <input id="globalQtyInput" name="quantity" type="number" value="1" min="1" max="99" class="w-20 text-center border-l border-r border-slate-200 py-2">
                        <button type="button" onclick="changeGlobalQty(1)" class="px-4 py-2 text-slate-700 hover:bg-slate-50">+</button>
                    </div>
                    <span id="globalStockInfo" class="text-sm text-slate-500"></span>
                </div>
                <p id="globalStockError" class="text-sm text-rose-500 hidden">Not enough stock available</p>
            </div>

            <button type="submit" class="w-full rounded-full bg-slate-900 text-white py-3 font-medium hover:bg-slate-800 transition">
                Add to Cart
            </button>
        </form>
    </div>
</div>


<script>
let globalSelectedOption = null;
let globalSelectedStock = 99;
let currentProductId = null;
let productHasOptions = false;

function openQuickBuyModal(productId, productName, hasOptions) {
    currentProductId = productId;
    productHasOptions = hasOptions;
    
    document.getElementById('modalProductName').textContent = productName;
    document.getElementById('globalQuickBuyForm').action = `/cart/add/${productId}`;
    
    // Reset form
    document.getElementById('globalQtyInput').value = 1;
    document.getElementById('globalOptionError').classList.add('hidden');
    document.getElementById('globalStockError').classList.add('hidden');
    
    if (hasOptions) {
        // Show loading state
        const grid = document.getElementById('sizeOptionsGrid');
        grid.innerHTML = '<div class="col-span-3 text-center py-4 text-slate-500">Loading options...</div>';
        document.getElementById('sizeOptionsContainer').classList.remove('hidden');
        
        // Fetch product options via AJAX
        fetch(`/api/products/${productId}/options`)
            .then(res => {
                if (!res.ok) throw new Error('Failed to fetch options');
                return res.json();
            })
            .then(data => {
                console.log('Options received:', data);
                
                grid.innerHTML = '';
                
                if (data.options && data.options.length > 0) {
                    data.options.forEach(opt => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = `global-option-btn px-4 py-3 rounded-lg border-2 border-slate-200 text-sm font-medium ${opt.in_stock ? 'hover:border-slate-900 hover:bg-slate-50' : 'opacity-50 cursor-not-allowed'}`;
                        btn.disabled = !opt.in_stock;
                        btn.dataset.id = opt.id;
                        btn.dataset.stock = opt.quantity;
                        btn.innerHTML = `${opt.label}<span class="block text-xs text-slate-500 mt-1">Stock: ${opt.quantity}</span>`;
                        btn.onclick = () => selectGlobalOption(btn, opt.quantity);
                        grid.appendChild(btn);
                    });
                    globalSelectedStock = 1;
                } else {
                    grid.innerHTML = '<div class="col-span-3 text-center py-4 text-slate-500">No options available</div>';
                }
            })
            .catch(error => {
                console.error('Error fetching options:', error);
                grid.innerHTML = '<div class="col-span-3 text-center py-4 text-red-500">Failed to load options</div>';
            });
    } else {
        document.getElementById('sizeOptionsContainer').classList.add('hidden');
        document.getElementById('globalStockInfo').textContent = '';
        globalSelectedStock = 99;
    }
    
    document.getElementById('globalQuickBuyModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeGlobalQuickBuy() {
    document.getElementById('globalQuickBuyModal').classList.add('hidden');
    document.body.style.overflow = '';
    
    // Reset
    document.querySelectorAll('.global-option-btn').forEach(b => {
        b.classList.remove('border-slate-900', 'bg-slate-100');
    });
    globalSelectedOption = null;
    globalSelectedStock = 99;
    document.getElementById('globalQtyInput').value = 1;
    document.getElementById('globalOptionError').classList.add('hidden');
    document.getElementById('globalStockError').classList.add('hidden');
}

function selectGlobalOption(btn, stock) {
    if (btn.disabled) return;
    
    document.querySelectorAll('.global-option-btn').forEach(b => {
        b.classList.remove('border-slate-900', 'bg-slate-100');
    });
    btn.classList.add('border-slate-900', 'bg-slate-100');
    
    globalSelectedOption = btn.dataset.id;
    globalSelectedStock = stock;
    document.getElementById('globalOptionHidden').value = globalSelectedOption;
    document.getElementById('globalOptionError').classList.add('hidden');
    document.getElementById('globalQtyInput').max = stock;
    document.getElementById('globalStockInfo').textContent = `${stock} available`;
    
    const qtyInput = document.getElementById('globalQtyInput');
    if (parseInt(qtyInput.value) > stock) {
        qtyInput.value = stock;
    }
}

function changeGlobalQty(delta) {
    const input = document.getElementById('globalQtyInput');
    const currentMax = globalSelectedStock;
    const newVal = Math.max(1, Math.min(currentMax, parseInt(input.value) + delta));
    input.value = newVal;
    validateGlobalStock();
}

function validateGlobalStock() {
    const input = document.getElementById('globalQtyInput');
    const qty = parseInt(input.value);
    const errorEl = document.getElementById('globalStockError');

    if (qty > globalSelectedStock) {
        input.value = globalSelectedStock;
        errorEl.classList.remove('hidden');
        setTimeout(() => errorEl.classList.add('hidden'), 3000);
    } else {
        errorEl.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('globalQtyInput').addEventListener('input', validateGlobalStock);

    document.getElementById('globalQuickBuyForm').addEventListener('submit', function(e) {
        if (productHasOptions && !globalSelectedOption) {
            e.preventDefault();
            document.getElementById('globalOptionError').classList.remove('hidden');
            return false;
        }
    });

    // Close modal on outside click
    document.getElementById('globalQuickBuyModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeGlobalQuickBuy();
        }
    });
});
</script>
