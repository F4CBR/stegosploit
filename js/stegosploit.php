<?php
call(new Func(function($g = null) use (&$isNaN, &$isFinite, &$Math, &$Array, &$document, &$Image, &$String) {
  $Cover = new Func("Cover", function() {
  });
  $util = new Object("isPrime", new Func(function($n = null) use (&$isNaN, &$isFinite, &$Math) {
    if (is(call($isNaN, $n)) || not(call($isFinite, $n)) || is((float)(to_number($n) % 1.0)) || $n < 2.0) {
      return false;
    }
    if (eq((float)(to_number($n) % 2.0), 0.0)) {
      return eq($n, 2.0);
    }
    if (eq((float)(to_number($n) % 3.0), 0.0)) {
      return eq($n, 3.0);
    }
    $m = call_method($Math, "sqrt", $n);
    for ($i = 5.0; $i <= $m; $i = _plus($i, 6.0)) {
      if (eq((float)(to_number($n) % to_number($i)), 0.0)) {
        return false;
      }
      if (eq((float)(to_number($n) % to_number(_plus($i, 2.0))), 0.0)) {
        return false;
      }
    }
    return true;
  }), "findNextPrime", new Func(function($n = null) use (&$util) {
    for ($i = $n; true; $i = _plus($i, 1.0)) {
      if (is(call_method($util, "isPrime", $i))) {
        return $i;
      }
    }
  }), "sum", new Func(function($func = null, $end = null, $options = null) {
    $sum = 0.0;
    $options = (is($or_ = $options) ? $or_ : new Object());
    for ($i = (is($or_ = get($options, "start")) ? $or_ : 0.0); $i < $end; $i = _plus($i, (is($or_ = get($options, "inc")) ? $or_ : 1.0))) {
      $sum = _plus($sum, (is($or_ = call($func, $i)) ? $or_ : 0.0));
    }
    return $sum === 0.0 && is(get($options, "defValue")) ? get($options, "defValue") : $sum;
  }), "product", new Func(function($func = null, $end = null, $options = null) {
    $prod = 1.0;
    $options = (is($or_ = $options) ? $or_ : new Object());
    for ($i = (is($or_ = get($options, "start")) ? $or_ : 0.0); $i < $end; $i = _plus($i, (is($or_ = get($options, "inc")) ? $or_ : 1.0))) {
      $prod *= (is($or_ = call($func, $i)) ? $or_ : 1.0);
    }
    return $prod === 1.0 && is(get($options, "defValue")) ? get($options, "defValue") : $prod;
  }), "createArrayFromArgs", new Func(function($args = null, $index = null, $threshold = null) use (&$Array) {
    $ret = _new($Array, to_number($threshold) - 1.0);
    for ($i = 0.0; $i < $threshold; $i = _plus($i, 1.0)) {
      set($ret, $i, call($args, $i >= $index ? _plus($i, 1.0) : $i));
    }
    return $ret;
  }));
  set($Cover, "prototype", new Object("config", new Object("t", 3.0, "threshold", 1.0, "codeUnitSize", 16.0, "args", new Func(function($i = null) {
    return _plus($i, 1.0);
  }), "messageDelimiter", new Func(function($modMessage = null, $threshold = null) use (&$Array) {
    $delimiter = _new($Array, to_number($threshold) * 3.0);
    for ($i = 0.0; $i < get($delimiter, "length"); $i = _plus($i, 1.0)) {
      set($delimiter, $i, 255.0);
    }
    return $delimiter;
  }), "messageCompleted", new Func(function($data = null, $i = null, $threshold = null) {
    $done = true;
    for ($j = 0.0; $j < 16.0 && is($done); $j = _plus($j, 1.0)) {
      $done = (is($and_ = $done) ? get($data, _plus($i, to_number($j) * 4.0)) === 255.0 : $and_);
    }
    return $done;
  })), "encode", new Func(function($message = null, $image = null, $options = null) use (&$document, &$Image, &$util, &$Math) {
    $this_ = Func::getContext();
    $options = (is($or_ = $options) ? $or_ : new Object());
    $config = get($this_, "config");
    $shadowCanvas = call_method($document, "createElement", "canvas"); $shadowCtx = call_method($shadowCanvas, "getContext", "2d");
    set(get($shadowCanvas, "style"), "display", "none");
    if (is(get($image, "length"))) {
      $dataURL = $image;
      $image = _new($Image);
      set($image, "src", $dataURL);
    }
    set($shadowCanvas, "width", (is($or_ = get($options, "width")) ? $or_ : get($image, "width")));
    set($shadowCanvas, "height", (is($or_ = get($options, "height")) ? $or_ : get($image, "height")));
    if (is(get($options, "height")) && is(get($options, "width"))) {
      call_method($shadowCtx, "drawImage", $image, 0.0, 0.0, get($options, "width"), get($options, "height"));
    } else {
      call_method($shadowCtx, "drawImage", $image, 0.0, 0.0);
    }

    $imageData = call_method($shadowCtx, "getImageData", 0.0, 0.0, get($shadowCanvas, "width"), get($shadowCanvas, "height")); $data = get($imageData, "data");
    $t = (is($or_ = get($options, "t")) ? $or_ : get($config, "t")); $threshold = (is($or_ = get($options, "threshold")) ? $or_ : get($config, "threshold")); $codeUnitSize = (is($or_ = get($options, "codeUnitSize")) ? $or_ : get($config, "codeUnitSize")); $bundlesPerChar = _divide($codeUnitSize, $t) >> 0.0; $overlapping = (float)(to_number($codeUnitSize) % to_number($t)); $messageDelimiter = (is($or_ = get($options, "messageDelimiter")) ? $or_ : get($config, "messageDelimiter")); $args = (is($or_ = get($options, "args")) ? $or_ : get($config, "args")); $prime = call_method($util, "findNextPrime", call_method($Math, "pow", 2.0, $t)); $modMessage = new Arr();
    for ($i = 0.0; $i <= get($message, "length"); $i = _plus($i, 1.0)) {
      $dec = (is($or_ = call_method($message, "charCodeAt", $i)) ? $or_ : 0.0); $curOverlapping = (float)(to_number($overlapping) * to_number($i) % to_number($t));
      if ($curOverlapping > 0.0 && is($oldDec)) {
        $mask = to_number(call_method($Math, "pow", 2.0, to_number($t) - to_number($curOverlapping))) - 1.0;
        $oldMask = to_number(call_method($Math, "pow", 2.0, $codeUnitSize)) * (1.0 - to_number(call_method($Math, "pow", 2.0, _negate($curOverlapping))));
        $left = (to_number($dec) & to_number($mask)) << to_number($curOverlapping);
        $right = (to_number($oldDec) & to_number($oldMask)) >> to_number($codeUnitSize) - to_number($curOverlapping);
        call_method($modMessage, "push", _plus($left, $right));
        if ($i < get($message, "length")) {
          $mask = to_number(call_method($Math, "pow", 2.0, 2.0 * to_number($t) - to_number($curOverlapping))) * (1.0 - to_number(call_method($Math, "pow", 2.0, _negate($t))));
          for ($j = 1.0; $j < $bundlesPerChar; $j = _plus($j, 1.0)) {
            $decM = to_number($dec) & to_number($mask);
            call_method($modMessage, "push", to_number($decM) >> to_number(_plus((to_number($j) - 1.0) * to_number($t), to_number($t) - to_number($curOverlapping))));
            $mask <<= $t;
          }
          if ((float)(to_number($overlapping) * to_number(_plus($i, 1.0)) % to_number($t)) === 0.0) {
            $mask = to_number(call_method($Math, "pow", 2.0, $codeUnitSize)) * (1.0 - to_number(call_method($Math, "pow", 2.0, _negate($t))));
            $decM = to_number($dec) & to_number($mask);
            call_method($modMessage, "push", to_number($decM) >> to_number($codeUnitSize) - to_number($t));
          } else if (_plus((float)(to_number($overlapping) * to_number(_plus($i, 1.0)) % to_number($t)), to_number($t) - to_number($curOverlapping)) <= $t) {
            $decM = to_number($dec) & to_number($mask);
            call_method($modMessage, "push", to_number($decM) >> to_number(_plus((to_number($bundlesPerChar) - 1.0) * to_number($t), to_number($t) - to_number($curOverlapping))));
          }

        }
      } else if ($i < get($message, "length")) {
        $mask = to_number(call_method($Math, "pow", 2.0, $t)) - 1.0;
        for ($j = 0.0; $j < $bundlesPerChar; $j = _plus($j, 1.0)) {
          $decM = to_number($dec) & to_number($mask);
          call_method($modMessage, "push", to_number($decM) >> to_number($j) * to_number($t));
          $mask <<= $t;
        }
      }

      $oldDec = $dec;
    }
    $delimiter = call($messageDelimiter, $modMessage, $threshold);
    for ($offset = 0.0; to_number(_plus($offset, $threshold)) * 4.0 <= get($data, "length") && _plus($offset, $threshold) <= get($modMessage, "length"); $offset = _plus($offset, $threshold)) {
      $qS = new Arr();
      for ($i = 0.0; $i < $threshold && _plus($i, $offset) < get($modMessage, "length"); $i = _plus($i, 1.0)) {
        $q = 0.0;
        for ($j = $offset; $j < _plus($threshold, $offset) && $j < get($modMessage, "length"); $j = _plus($j, 1.0)) {
          $q = _plus($q, to_number(get($modMessage, $j)) * to_number(call_method($Math, "pow", call($args, $i), to_number($j) - to_number($offset))));
        }
        set($qS, $i, _plus(255.0 - to_number($prime), 1.0, (float)(to_number($q) % to_number($prime))));
      }
      for ($i = to_number($offset) * 4.0; $i < to_number(_plus($offset, get($qS, "length"))) * 4.0 && $i < get($data, "length"); $i = _plus($i, 4.0)) {
        set($data, _plus($i, 3.0), get($qS, (float)(_divide($i, 4.0) % to_number($threshold))));
      }
      $subOffset = get($qS, "length");
    }
    for ($index = _plus($offset, $subOffset); to_number($index) - to_number(_plus($offset, $subOffset)) < get($delimiter, "length") && to_number(_plus($offset, get($delimiter, "length"))) * 4.0 < get($data, "length"); $index = _plus($index, 1.0)) {
      set($data, _plus(to_number($index) * 4.0, 3.0), get($delimiter, to_number($index) - to_number(_plus($offset, $subOffset))));
    }
    for ($i = _plus(to_number(_plus($index, 1.0)) * 4.0, 3.0); $i < get($data, "length"); $i = _plus($i, 4.0)) {
      set($data, $i, 255.0);
    }
    set($imageData, "data", $data);
    call_method($shadowCtx, "putImageData", $imageData, 0.0, 0.0);
    return call_method($shadowCanvas, "toDataURL");
  }), "decode", new Func(function($image = null, $options = null) use (&$util, &$Math, &$document, &$Image, &$String) {
    $this_ = Func::getContext();
    $options = (is($or_ = $options) ? $or_ : new Object());
    $config = get($this_, "config");
    $t = (is($or_ = get($options, "t")) ? $or_ : get($config, "t")); $threshold = (is($or_ = get($options, "threshold")) ? $or_ : get($config, "threshold")); $codeUnitSize = (is($or_ = get($options, "codeUnitSize")) ? $or_ : get($config, "codeUnitSize")); $prime = call_method($util, "findNextPrime", call_method($Math, "pow", 2.0, $t)); $args = (is($or_ = get($options, "args")) ? $or_ : get($config, "args")); $modMessage = new Arr(); $messageCompleted = (is($or_ = get($options, "messageCompleted")) ? $or_ : get($config, "messageCompleted"));
    if (not($t) || $t < 1.0 && $t > 7.0) {
      throw new Ex(_concat("Error: Parameter t = ", $t, " is not valid: 0 < t < 8"));
    }
    $shadowCanvas = call_method($document, "createElement", "canvas"); $shadowCtx = call_method($shadowCanvas, "getContext", "2d");
    set(get($shadowCanvas, "style"), "display", "none");
    call_method(get($document, "body"), "appendChild", $shadowCanvas);
    if (is(get($image, "length"))) {
      $dataURL = $image;
      $image = _new($Image);
      set($image, "src", $dataURL);
    }
    set($shadowCanvas, "width", (is($or_ = get($options, "width")) ? $or_ : get($image, "width")));
    set($shadowCanvas, "height", (is($or_ = get($options, "width")) ? $or_ : get($image, "height")));
    if (is(get($options, "height")) && is(get($options, "width"))) {
      call_method($shadowCtx, "drawImage", $image, 0.0, 0.0, get($options, "width"), get($options, "height"));
    } else {
      call_method($shadowCtx, "drawImage", $image, 0.0, 0.0);
    }

    $imageData = call_method($shadowCtx, "getImageData", 0.0, 0.0, get($shadowCanvas, "width"), get($shadowCanvas, "height"));
    $data = get($imageData, "data");
    if ($threshold === 1.0) {
      for ($i = 3.0, $done = false; not($done) && $i < get($data, "length") && not($done); $i = _plus($i, 4.0)) {
        $done = call($messageCompleted, $data, $i, $threshold);
        if (not($done)) {
          call_method($modMessage, "push", to_number(get($data, $i)) - to_number(_plus(255.0 - to_number($prime), 1.0)));
        }
      }
    } else {
      for ($k = 0.0, $done = false; not($done); $k = _plus($k, 1.0)) {
        $q = new Arr();
        for ($i = _plus(to_number($k) * to_number($threshold) * 4.0, 3.0); $i < to_number(_plus($k, 1.0)) * to_number($threshold) * 4.0 && $i < get($data, "length") && not($done); $i = _plus($i, 4.0)) {
          $done = call($messageCompleted, $data, $i, $threshold);
          if (not($done)) {
            call_method($q, "push", to_number(get($data, $i)) - to_number(_plus(255.0 - to_number($prime), 1.0)));
          }
        }
        if (get($q, "length") === 0.0) {
          continue;
        }
        $variableCoefficients = call(new Func(function($i = null) use (&$q, &$util, &$args) {
          $arguments = Func::getArguments();
          if ($i >= get($q, "length")) {
            return new Arr();
          }
          return call_method(new Arr(to_number(get($q, $i)) * to_number(call_method($util, "product", new Func(function($j = null) use (&$i, &$util, &$q, &$args) {
            if (!eq($j, $i)) {
              return call_method($util, "product", new Func(function($l = null) use (&$j, &$args) {
                if (!eq($l, $j)) {
                  return to_number(call($args, $j)) - to_number(call($args, $l));
                }
              }), get($q, "length"));
            }
          }), get($q, "length")))), "concat", call_method($arguments, "callee", _plus($i, 1.0)));
        }), 0.0);
        $orderVariableCoefficients = new Func(function($order = null, $varIndex = null) use (&$args, &$util, &$q) {
          $workingArgs = call_method($util, "createArrayFromArgs", $args, $varIndex, get($q, "length")); $maxRec = to_number(get($q, "length")) - to_number(_plus($order, 1.0));
          return call(new Func(function($startIndex = null, $endIndex = null, $recDepth = null) use (&$util, &$maxRec, &$workingArgs, &$order) {
            $arguments = Func::getArguments();
            $recall = get($arguments, "callee");
            return call_method($util, "sum", new Func(function($i = null) use (&$recDepth, &$maxRec, &$workingArgs, &$recall, &$startIndex, &$order) {
              if ($recDepth < $maxRec) {
                return to_number(get($workingArgs, $i)) * to_number(call($recall, _plus($i, 1.0), _plus($startIndex, $order, 2.0), _plus($recDepth, 1.0)));
              }
            }), $endIndex, new Object("start", $startIndex, "defValue", 1.0));
          }), 0.0, _plus($order, 1.0), 0.0);
        });
        $commonDenominator = call_method($util, "product", new Func(function($i = null) use (&$util, &$q, &$args) {
          return call_method($util, "product", new Func(function($j = null) use (&$i, &$args) {
            if (!eq($j, $i)) {
              return to_number(call($args, $i)) - to_number(call($args, $j));
            }
          }), get($q, "length"));
        }), get($q, "length"));
        for ($i = 0.0; $i < get($q, "length"); $i = _plus($i, 1.0)) {
          call_method($modMessage, "push", (float)(to_number(_plus((float)(to_number(call_method($Math, "pow", -1.0, to_number(get($q, "length")) - to_number(_plus($i, 1.0)))) * to_number(call_method($util, "sum", new Func(function($j = null) use (&$orderVariableCoefficients, &$i, &$variableCoefficients) {
            return to_number(call($orderVariableCoefficients, $i, $j)) * to_number(get($variableCoefficients, $j));
          }), get($q, "length"))) % to_number($prime)), $prime)) % to_number($prime)));
        }
      }
    }

    $message = ""; $charCode = 0.0; $bitCount = 0.0; $mask = to_number(call_method($Math, "pow", 2.0, $codeUnitSize)) - 1.0;
    for ($i = 0.0; $i < get($modMessage, "length"); $i = _plus($i, 1.0)) {
      $charCode = _plus($charCode, to_number(get($modMessage, $i)) << to_number($bitCount));
      $bitCount = _plus($bitCount, $t);
      if ($bitCount >= $codeUnitSize) {
        $message = _plus($message, call_method($String, "fromCharCode", to_number($charCode) & to_number($mask)));
        $bitCount %= $codeUnitSize;
        $charCode = to_number(get($modMessage, $i)) >> to_number($t) - to_number($bitCount);
      }
    }
    if ($charCode !== 0.0) {
      $message = _plus($message, call_method($String, "fromCharCode", to_number($charCode) & to_number($mask)));
    }
    return $message;
  }), "getHidingCapacity", new Func(function($image = null, $options = null) {
    $this_ = Func::getContext();
    $options = (is($or_ = $options) ? $or_ : new Object());
    $config = get($this_, "config");
    $width = (is($or_ = get($options, "width")) ? $or_ : get($image, "width")); $height = (is($or_ = get($options, "height")) ? $or_ : get($image, "height")); $t = (is($or_ = get($options, "t")) ? $or_ : get($config, "t")); $codeUnitSize = (is($or_ = get($options, "codeUnitSize")) ? $or_ : get($config, "codeUnitSize"));
    return _divide(to_number($t) * to_number($width) * to_number($height), $codeUnitSize) >> 0.0;
  })));
  set($g, "steganography", set($g, "steg", _new($Cover)));
}), $window);
