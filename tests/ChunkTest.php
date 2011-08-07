<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Test chunks
 *
 * PHP version 5
 *
 * LICENSE: 
 *
 * Copyright (c) 2011 Igor Feghali
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 *
 *  Redistributions of source code must retain the above copyright notice, this 
 *  list of conditions and the following disclaimer.
 *
 *  Redistributions in binary form must reproduce the above copyright notice, 
 *  this list of conditions and the following disclaimer in the documentation 
 *  and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Encryption
 * @package   Crypt_RSA2
 * @author    Igor Feghali <ifeghali@php.net>
 * @copyright 1997-2011 The PHP Group
 * @license   http://opensource.org/licenses/bsd-license.php BSD License
 * @version   SVN: $Id$
 * @link      http://pear.php.net/package/Crypt_RSA2
 * @see       Crypt_RSA
 * @since     File available since Release 0.1.0
 */

require_once 'Crypt/RSA2.php';

class Crypt_RSA2_ChunkTest extends PHPUnit_Framework_TestCase
{
    protected $rsa;
    protected $keys;

    public function setUp()
    {
        $this->keys = array(
            'private' => '606869471787592237184668157935217904976599635555207749721675975928209477579912815181212173478003164772946768212428636267600208461747020311280793581488357',
            'public' => '49359871496423200753771298972894344193519716517922230440098197444805618348973',
            'modulus' => '16777259'
        );

        $this->r1 = new Crypt_RSA2($this->keys);
        $this->r2 = new Crypt_RSA2($this->keys);
    }

    /**
     * @dataProvider providerModulus
     */
    function testChunkSize($cs, $n)
    {
        $this->keys['modulus'] = $n;
        extract($this->keys);

        $this->r2->setKeys($private, $public, $modulus);

        $this->assertEquals($cs, $this->r2->chunkSize());
    }

    function testCascade()
    {
        $secret = 'a';

        $encrypted = $this->r1->encrypt($secret);

        $this->assertEquals($secret, $this->r1->decrypt($encrypted));
    }

    function providerModulus()
    {
        return array(
            array(0, hexdec('FF')),
            array(0, hexdec('FFF')),
            array(0, hexdec('FFFF')),
            array(2, hexdec('FFFFF')),
            array(2, hexdec('FFFFFF')),
            array(2, hexdec('FFFFFFF')),
            array(2, hexdec('FFFFFFFF')),
            array(4, hexdec('FFFFFFFFF')),
            array(4, hexdec('FFFFFFFFFF')),
            array(4, hexdec('FFFFFFFFFFF')),
            array(4, hexdec('FFFFFFFFFFFF')),
            array(6, hexdec('FFFFFFFFFFFFF')),
        );
    }
}
