function ready(fn) {
    if (document.readyState != 'loading'){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

// Rose Water
// @link https://uigradients.com/#RoseWater
var color_config = [
    { pct: 0.0, color: { r: 0xe5, g: 0x5d, b: 0x87 } },
    { pct: 1.0, color: { r: 0x5f, g: 0xc3, b: 0xe4 } }
];

// @link http://stackoverflow.com/a/7128796
// @return string - Returns `rgb()` CSS string to be used as a style
var getColorForPercentage = function(pct, percent_colors) {
    for (var i = 1; i < percent_colors.length - 1; i++) {
        if (pct < percent_colors[i].pct) {
            break;
        }
    }

    var lower = percent_colors[i - 1];
    var upper = percent_colors[i];
    var range = upper.pct - lower.pct;
    var rangePct = (pct - lower.pct) / range;
    var pct_lower = 1 - rangePct;
    var pct_upper = rangePct;
    var color = {
        r: Math.floor(lower.color.r * pct_lower + upper.color.r * pct_upper),
        g: Math.floor(lower.color.g * pct_lower + upper.color.g * pct_upper),
        b: Math.floor(lower.color.b * pct_lower + upper.color.b * pct_upper)
    };

    return 'rgb(' + [color.r, color.g, color.b].join(',') + ')';
};

ready(function() {
    var cells = document.querySelectorAll('.percent');

    var percentages = [];
    [].forEach.call(cells, function(td) {
        percentages.push(parseFloat(td.innerText));
    });

    var max_percentage = Math.max.apply(null, percentages);
    var min_percentage = Math.min.apply(null, percentages);

    // Apply shading to each percentage cell
    [].forEach.call(cells, function(td) {
        var current_percentage = parseFloat(td.innerText);
        var cell_shade_percent = (current_percentage - min_percentage) / (max_percentage - min_percentage);
        var cell_bg_color = getColorForPercentage(cell_shade_percent, color_config);
        td.style.backgroundColor = cell_bg_color;
    });
});

